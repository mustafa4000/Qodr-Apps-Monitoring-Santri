@extends('templates.base')

@section('content')

@include('components.page-header', [
    'title' => 'Cash Flow',
    'subtitle' => 'Managent Cash Flow',
    'breadcrumb' => [
        'Cash Flow'
    ]
])

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info icons-alert alert-cashflow">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="saveAlert()">
                    <i class="icofont icofont-close-line-circled"></i>
                </button>
                <ul>
                    <li>1. shortcut for add row use <code>ctrl + space</code></li>
                    <li>2. shortcut for submit row use <code>ctrl + enter</code></li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header card-list">
                    <h5>List Data</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="cash_flow_id" id="cash_flow_id" class="form-control">
                                    {!! HelperTag::cashflow() !!}
                                </select>
                            </div>
                        </div>
                        <div class="col"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-block" onclick="addRow()">
                                    <i class="feather icon-plus"></i> Add Row
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-list">
                            <thead>
                                <tr class="bg-primary">
                                    <th width="45">No</th>
                                    <th width="103">Date</th>
                                    <th width="100">For</th>
                                    <th width="80">Qty</th>
                                    <th width="100">Type</th>
                                    <th width="140">Price</th>
                                    <th width="140">Debit</th>
                                    <th width="140">Kredit</th>
                                    <th width="140">Total</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody id="listitem">
                                @php($total = 0)
                                @foreach($cashflow as $item)
                                @php($total = $total + $item->debit - $item->kredit)
                                <tr id="row-cashflow-{{ $item->id }}" {!! $disable ? 'class="disabled-row"' : '' !!}>
                                    <td align="center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->dateIndo() }}</td>
                                    <td>{{ $item->for }}</td>
                                    <td align="center">{{ $item->qty }}</td>
                                    <td align="center">{{ $item->type }}</td>
                                    <td align="right">{!! HelperView::currency($item->price) !!}</td>
                                    <td align="right">{!! HelperView::currency($item->debit) !!}</td>
                                    <td align="right">{!! HelperView::currency($item->kredit) !!}</td>
                                    <td align="right">{!! HelperView::currency($total) !!}</td>
                                    <td class="action" align="center">
                                        @php($dataEdit = $item->toArray())
                                        @php($dataEdit['total'] = $total)
                                        @if (!$disable)
                                        <button type="button" class="btn btn-primary btn-sm pr-2" onclick="edit({{ $item->id }}, '{{ json_encode($dataEdit) }}')">
                                            <i class="feather icon-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm pr-2" onclick="deleted({{ $item->id }})">
                                            <i class="feather icon-trash-2"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" align="right"><b>TOTAL</b></td>
                                    <td align="right"><b>{!! !empty($parent->debit) ? HelperView::currency($parent->debit) : HelperView::currency(0) !!}</b></td>
                                    <td align="right"><b>{!! !empty($parent->kredit) ? HelperView::currency($parent->kredit) : HelperView::currency(0) !!}</b></td>
                                    <td align="right"><b>{!! !empty($parent->total) ? HelperView::currency($parent->total) : HelperView::currency(0) !!}</b></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="new-row" style="display:none">
    <table>
        <tbody>
            <tr class="add-row">
                <td class="p-1">
                    <button type="button" class="btn btn-danger btn-sm pr-2 btn-remove" onclick="removeRow(this)">
                        <i class="feather icon-x"></i>
                    </button>
                </td>
                <td class="p-1">
                    <input type="date" name="date" id="date" class="form-control" placeholder="date" data-toggle="tooltip" data-placement="bottom" title="required" data-trigger="manual">
                </td>
                <td class="p-1">
                    <input type="text" name="for" id="for" class="form-control" placeholder="for" data-toggle="tooltip" data-placement="bottom" title="required" data-trigger="manual">
                </td>
                <td class="p-1">
                    <input type="number" name="qty" id="qty" min="1" class="form-control" value="1" onkeyup="countTotal()" onchange="countTotal()" placeholder="qty" data-toggle="tooltip" data-placement="bottom" title="required" data-trigger="manual">
                </td>
                <td class="p-1">
                    <select name="type" id="type" class="form-control" onchange="countTotal()" data-toggle="tooltip" data-placement="bottom" title="required" data-trigger="manual">
                        {!! HelperTag::setting('type_rab', true) !!}
                    </select>
                </td>
                <td class="p-1">
                    <input type="text" name="price" id="price" class="form-control" value="0" onkeyup="countTotal()" onchange="countTotal()" placeholder="price" data-toggle="tooltip" data-placement="bottom" title="required" data-trigger="manual">
                </td>
                <td class="p-1">
                    <input type="text" name="debit" disabled id="debit" class="form-control" value="0">
                </td>
                <td class="p-1">
                    <input type="text" name="kredit" disabled id="kredit" class="form-control" value="0">
                </td>
                <td class="p-1">
                    <select name="to" id="to" class="form-control" onchange="countTotal()">
                        <option value="kredit">kredit</option>
                        <option value="debit">debit</option>
                    </select>
                </td>
                <td class="p-1">
                    <button type="button" class="btn btn-primary btn-sm btn-block btn-submit" onclick="createRow()">
                        submit
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@include('pages.rab.form')
@endsection

@section('javascript')
{{ HTML::script('plugins/form-masking/autoNumeric.js') }}
{{ HTML::script('js/pages/cashflow.js') }}
@endsection