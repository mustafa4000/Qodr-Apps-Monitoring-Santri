@extends('templates.base')

@section('content')

@include('components.page-header', [
'title' => 'Soal',
'subtitle' => 'Manajement Soal',
'breadcrumb' => [
'Master',
'Soal'
]
])

@include('templates.alert')
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header card-list">
                    <h5>List Soal</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-maximize full-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="col-md-2">
                        {{-- <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#form-soal">
                                <i class="feather icon-plus"></i> Add
                            </button> --}}
                        <a href="{{ url('/soal/create') }}" class="btn btn-primary btn-block"><i class="feather icon-plus"></i> Add</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-list">
                        <thead>
                            <tr class="bg-primary">
                                <th>No</th>
                                <th>Judul Soal</th>
                                <th>Kategori</th>
                                <th>Catatan</th>
                                <th>Is_Active</th>
                                <th>Pembuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="listitem">
                            @foreach ($questions as $item)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->note }}</td>
                                <td>{{ $item->is_active}}</td>
                                <td>{{ $item->user->username }}</td>
                                <td class="action">
                                    <div class="dropdown-primary dropdown open btn-block">
                                        <button class="btn btn-primary btn-sm btn-block dropdown-toggle" type="button"
                                            id="action" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="true">
                                            <i class="feather icon-cpu"></i> Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="action" data-dropdown-in="fadeIn"
                                            data-dropdown-out="fadeOut">
                                            <form action="{{url('soal/'.$item->id)}}" method="post">
                                                @method('delete')
                                                @csrf
                                                <a href="{{url('soal/'.$item->id.'/edit') }}" class="dropdown-item">
                                                    <i class="feather icon-edit"></i> Edit
                                                </a>
                                                <button type="submit" class="dropdown-item btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ?');">
                                                    <i class="feather icon-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('css')
<style>
    select.form-control:not([size]):not([multiple]) {
        height: calc(2.25rem + 2px);
        margin-left: 32px;
        padding: 1px;
    }

    div.dataTables_wrapper div.dataTables_info {
        display: inline-block;
        margin-left: 32px;
    }

</style>
@endpush
@section('css')
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css"
    href="{{asset ('plugins\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{asset ('plugins\assets\pages\data-table\css\buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{asset ('plugins\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{asset ('plugins\assets\pages\data-table\extensions\autofill\css\autoFill.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{asset ('plugins\assets\pages\data-table\extensions\autofill\css\select.dataTables.min.css') }}">
@endsection

@section('javascript')
<!-- data-table js -->
<script src="{{ asset ('plugins\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
<script src="{{ asset ('plugins\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
<script src="{{ asset ('plugins\assets\pages\data-table\js\jszip.min.js') }}"></script>
<script src="{{ asset ('plugins\assets\pages\data-table\js\pdfmake.min.js') }}"></script>
<script src="{{ asset ('plugins\assets\pages\data-table\js\vfs_fonts.js') }}"></script>
<script src="{{ asset ('plugins\assets\pages\data-table\extensions\autofill\js\dataTables.autoFill.min.js') }}">
</script>
<script src="{{ asset ('plugins\assets\pages\data-table\extensions\autofill\js\dataTables.select.min.js') }}"></script>
<script src="{{ asset ('plugins\bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
<script src="{{ asset ('plugins\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
<script src="{{ asset ('plugins\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset ('plugins\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}">
</script>
<script src="{{ asset ('plugins\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
</script>
<script>
    $(document).ready(function () {
        $('.table').DataTable({
            language: {
                "sProcessing": "Sedang proses...",
                "sLengthMenu": "_MENU_ ",
                "sZeroRecords": "Tidak ditemukan data yang sesuai",
                "sInfo": "Tampilan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Tampilan 0 hingga 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix": "",
                "sSearch": "Cari:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Awal",
                    "sPrevious": "<i class='fa fa-arrow-left'><i> Kembali",
                    "sNext": "Lanjut",
                    "sLast": "Akhir"
                }
            }

        });
    });

</script>
@endsection