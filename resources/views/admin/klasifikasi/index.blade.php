@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <button onclick="modalAction('{{ secure_url('/klasifikasi/import') }}')" class="btn btn-info">Import Klasifikasi</button>
                <a href="{{ secure_url('/klasifikasi/export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export Excel</a>
                <a href="{{ secure_url('/klasifikasi/export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export PDF</a>
                <button onclick="modalAction('{{ secure_url('/klasifikasi/create_ajax') }}')" class="btn btn-success">
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
                <table class="table table-bordered table-striped table-hover" id="table_klasifikasi">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Klasifikasi</th>
                            <th>Nama Klasifikasi</th>
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

        var dataKlasifikasi;
        $(document).ready(function() {
            window.dataKlasifikasi = $('#table_klasifikasi').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ secure_url('klasifikasi/list') }}",
                    type: "POST"
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "klasifikasi_kode", className: "", orderable: true, searchable: true },
                    { data: "klasifikasi_nama", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
