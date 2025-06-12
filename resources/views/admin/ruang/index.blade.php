@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/ruang/import') }}')" class="btn btn-info">Import Ruang</button>
                <a href="{{ url('/ruang/export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export Ruang</a>
                <a href="{{ url('/ruang/export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export Ruang</a>
                <button onclick="modalAction('{{ url('/ruang/create_ajax') }}')" class="btn btn-success">
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
                <table class="table table-bordered table-striped table-hover" id="table_ruang">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lokasi</th>
                            <th>Kode Ruang</th>
                            <th>Nama Ruang</th>
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

        var dataRuang;
        $(document).ready(function() {
            window.dataRuang = $('#table_ruang').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('ruang/list') }}",
                    type: "POST"
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "lantai_info", className: "", orderable: true, searchable: true },
                    { data: "ruang_kode", className: "", orderable: true, searchable: true },
                    { data: "ruang_nama", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush