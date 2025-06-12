@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                {{-- <button onclick="modalAction('{{ url('/lantai/import') }}')" class="btn btn-info">Import Lantai</button>
                <a href="{{ url('/lantai/export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export Lantai</a>
                <a href="{{ url('/lantai/export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export Lantai</a> --}}
                <button onclick="modalAction('{{ url('/lantai/create_ajax') }}')" class="btn btn-success">
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
                <table class="table table-bordered table-striped table-hover" id="table_lantai">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gedung</th>
                            <th>Nomor Lantai</th>
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

        var dataLantai;
        $(document).ready(function() {
            window.dataLantai = $('#table_lantai').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('lantai/list') }}",
                    type: "POST"
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "gedung_nama", className: "", orderable: true, searchable: true },
                    { data: "lantai_nomor", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush