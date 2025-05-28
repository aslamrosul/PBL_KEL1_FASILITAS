@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/kriteria/import') }}')" class="btn btn-info">Import Kriteria</button>
                <a href="{{ url('/kriteria/export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export Excel</a>
                <a href="{{ url('/kriteria/export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export PDF</a>
                <button onclick="modalAction('{{ url('/kriteria/create_ajax') }}')" class="btn btn-success">
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
                <table class="table table-bordered table-striped table-hover" id="table_kriteria">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Kriteria</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

@push('js')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   

    <script>
        function modalAction(url = '') {
            jQuery('#myModal').load(url, function() {
                var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                    keyboard: false,
                    backdrop: 'static'
                });
                myModal.show();
            });
        }

        var dataKriteria;
        jQuery(document).ready(function() {
            window.dataKriteria = jQuery('#table_kriteria').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('kriteria/list') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "kriteria_kode", className: "", orderable: true, searchable: true },
                    { data: "kriteria_nama", className: "", orderable: true, searchable: true },
                    { data: "bobot", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush