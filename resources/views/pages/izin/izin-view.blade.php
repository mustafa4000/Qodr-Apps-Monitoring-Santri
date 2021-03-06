@extends('templates.base')

@section('content')

@include('components.page-header', [
    'title' => 'Izin Student',
    'subtitle' => 'System Izin Student',
    'breadcrumb' => [
        'izin student'
    ]
])

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-list">
                    <h5>List Izin</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="showitem" class="form-control" data-url="/izin/list">
                                    {!! HelperTag::showItem(request()->show ?? 5) !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="daterange" class="form-control" placeholder="Date Range">
                            </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-button">
                                <input type="text" name="keyword" data-url="/izin/list" class="form-control" placeholder="Search ..." value="{{ request()->keyword }}">
                                <button type="button" class="input-group-addon btn btn-primary btn-paginate-search" data-url="/izin/list">
                                    <i class="feather icon-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-list">
                            <thead>
                                <tr class="bg-primary">
                                    <th width="40">No</th>
                                    <th>Information</th>
                                    <th width="160">Start</th>
                                    <th width="160">End</th>
                                    <th width="100">Status</th>
                                    <th width="190">Action</th>
                                </tr>
                            </thead>
                            <tbody id="listitem">
                                @php($no = $izin->perPage() * $izin->currentPage() - $izin->perPage() + 1)
                                @foreach ($izin as $item)    
                                <tr>
                                    <td align="center">{{ $no }}</td>
                                    <td>{{ $item->information }}</td>
                                    <td align="center">{{ date('H:i | d F Y', strtotime($item->start)) }}</td>
                                    <td align="center">{{ date('H:i | d F Y', strtotime($item->end)) }}</td>
                                    <td align="center">
                                        @if ($item->approved === 1)
                                        <span class="label label-success">Approved</span>
                                        @elseif ($item->approved === 0)
                                        <span class="label label-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        @if (is_null($item->approved))
                                        <div class="dropdown-primary dropdown open btn-block">
                                            <button class="btn btn-primary btn-sm btn-block dropdown-toggle" type="button" id="action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="feather icon-cpu"></i> Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                <a class="dropdown-item" onclick="approved({{ $item->id }}, {{ $userId }}, 1)">
                                                    <i class="feather icon-user-check"></i> Approve
                                                </a>
                                                <a class="dropdown-item" onclick="approved({{ $item->id }}, {{ $userId }}, 0)">
                                                    <i class="feather icon-user-x"></i> Reject
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @php($no = $no + 1)
                                @endforeach

                                @if ($izin->total() < 1)
                                <tr>
                                    <td colspan="6" align="center">Data not found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right" id="pagination">
                        {{ $izin->links('components.pagination.ajax') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
{{ HTML::script('plugins/moment/moment.min.js') }}
{{ HTML::script('plugins/daterangepicker/daterangepicker.js') }}
{{ HTML::script('js/pages/izin.js') }}
@endsection