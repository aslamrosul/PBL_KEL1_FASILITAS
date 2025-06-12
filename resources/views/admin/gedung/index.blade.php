@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <button onclick="modalAction('{{ secure_url('/gedung/import') }}')" class="btn btn-info">Import Gedung</button>
                <a href="{{ secure_url('/gedung/export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export Gedung</a>
                <a href="{{ secure_url('/gedung/export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export Gedung</a>
                <button onclick="modalAction('{{ secure_url('/gedung/create_ajax') }}')" class="btn btn-success">
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
                <table class="table table-bordered table-striped table-hover" id="table_gedung">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Gedung</th>
                            <th>Nama Gedung</th>
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

        var dataGedung;
        $(document).ready(function() {
            window.dataGedung = $('#table_gedung').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ secure_url('gedung/list') }}",
                    type: "POST"
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "gedung_kode", className: "", orderable: true, searchable: true },
                    { data: "gedung_nama", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush