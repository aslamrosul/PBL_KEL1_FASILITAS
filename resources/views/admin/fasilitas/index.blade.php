@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/fasilitas/import') }}')" class="btn btn-info">Import Fasilitas</button>
                <a href="{{ url('/fasilitas/export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export Excel</a>
                <a href="{{ url('/fasilitas/export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export PDF</a>
                <button onclick="modalAction('{{ url('/fasilitas/create_ajax') }}')" class="btn btn-success">
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
                <table class="table table-bordered table-striped table-hover" id="table_fasilitas">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ruang</th>
                            <th>Barang</th>
                            <th>Kode Fasilitas</th>
                            <th>Nama Fasilitas</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Tahun Pengadaan</th>
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        var dataFasilitas;
        jQuery(document).ready(function() {
            window.dataFasilitas = jQuery('#table_fasilitas').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('fasilitas/list') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "ruang_nama", className: "", orderable: true, searchable: true },
                    { data: "barang_nama", className: "", orderable: true, searchable: true },
                    { data: "fasilitas_kode", className: "", orderable: true, searchable: true },
                    { data: "fasilitas_nama", className: "", orderable: true, searchable: true },
                    { data: "keterangan", className: "", orderable: true, searchable: true },
                   {
                        data: "status", render: function (data) {
                            return renderStatusBadge(data);
                        },
                        className: "", orderable: true, searchable: true
                    },
                    { data: "tahun_pengadaan", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush