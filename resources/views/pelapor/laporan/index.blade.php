@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="modal-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/pelapor/laporan/create_ajax') }}')" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Laporan
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
                <table class="table table-bordered table-striped table-hover" id="table_laporan">
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

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('js')
<script>
    function renderStatusBadge(status) {
        let badgeClass = '';
        switch (status) {
            case 'menunggu':
                badgeClass = 'badge bg-warning';
                break;
            case 'diproses':
                badgeClass = 'badge bg-primary';
                break;
            case 'selesai':
                badgeClass = 'badge bg-success';
                break;
            default:
                badgeClass = 'badge bg-secondary';
        }
        return `<span class="${badgeClass}">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
    }

    function modalAction(url = '') {
        jQuery('#myModal').load(url, function() {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                keyboard: false,
                backdrop: 'static'
            });
            myModal.show();
        });
    }

    jQuery(document).ready(function() {
        window.dataLaporan = jQuery('#table_laporan').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ url('pelapor/laporan/list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "judul", className: "", orderable: true, searchable: true },
                { data: "periode.periode_nama", className: "", orderable: true, searchable: true, defaultContent: '-' },
                { data: "fasilitas.fasilitas_nama", className: "", orderable: true, searchable: true, defaultContent: '-' },
                {
                    data: "status",
                    render: function(data) {
                        return renderStatusBadge(data);
                    },
                    className: "text-center", orderable: true, searchable: true
                },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush