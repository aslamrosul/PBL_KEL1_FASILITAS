@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/periode/import') }}')" class="btn btn-info">Import Periode</button>
                <a href="{{ url('/periode/export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export Periode</a>
                <a href="{{ url('/periode/export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export Periode</a>
                <button onclick="modalAction('{{ url('/periode/create_ajax') }}')" class="btn btn-success">
                    Tambah Ajax
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="table_periode">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Periode</th>
                            <th>Nama Periode</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                    keyboard: false,
                    backdrop: 'static'
                });
                myModal.show();
            });
        }

        var dataPeriode;
        $(document).ready(function() {
            window.dataPeriode = $('#table_periode').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('periode/list') }}",
                    type: "POST"
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "periode_kode", className: "", orderable: true, searchable: true },
                    { data: "periode_nama", className: "", orderable: true, searchable: true },
                    { data: "tanggal_mulai", className: "", orderable: true, searchable: true },
                    { data: "tanggal_selesai", className: "", orderable: true, searchable: true },
                    { data: "is_aktif", className: "text-center", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush