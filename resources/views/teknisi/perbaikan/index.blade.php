@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="table_perbaikan">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Laporan</th>
                            <th>Fasilitas</th>
                            <th>Tanggal Mulai</th>
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
            $('#myModal').load(url, function () {
                var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                    keyboard: false,
                    backdrop: 'static'
                });
                myModal.show();
            });
        }
        
        $(document).ready(function() {
            var dataPerbaikan = $('#table_perbaikan').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('teknisi/perbaikan/list') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "laporan.judul", className: "", orderable: true, searchable: true },
                    { data: "laporan.fasilitas.fasilitas_nama", className: "", orderable: true, searchable: true },
                    { data: "tanggal_mulai", className: "", orderable: true, searchable: true },
                   {
                        data: "status", render: function (data) {
                            return renderStatusBadge(data);
                        },
                        className: "", orderable: true, searchable: true
                    },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush