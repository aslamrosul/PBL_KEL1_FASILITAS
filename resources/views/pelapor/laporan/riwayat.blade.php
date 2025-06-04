@extends('layouts.template')

@section('content')

    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="riwayat-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Periode</th>
                            <th>Fasilitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true"></div>

@endsection


@push('js')
    <script>
        function modalAction(url = '') {
            jQuery('#myModal').load(url, function () {
                var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                    keyboard: false,
                    backdrop: 'static'
                });
                myModal.show();
            });
        }
        jQuery(document).ready(function () {
            window.dataRiwayat = jQuery('#riwayat-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pelapor.riwayat.list') }}",
                    type: "POST", // Ganti ke POST jika diperlukan
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "judul", className: "", orderable: true, searchable: true },
                    { data: "periode.periode_nama", className: "", orderable: true, searchable: true },
                    { data: "fasilitas.fasilitas_nama", className: "", orderable: true, searchable: true },
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