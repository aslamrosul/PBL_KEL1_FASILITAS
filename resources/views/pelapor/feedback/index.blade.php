@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">{{ $page->title }}</h4>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="table_feedback">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Laporan</th>
                        <th>Rating</th>
                        <th>Status Laporan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table_feedback').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ route('pelapor.feedback.list') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { 
                        data: "laporan.judul", 
                        className: "",
                        render: function(data, type, row) {
                            return data || '-';
                        }
                    },
                    { 
                        data: "rating", 
                        className: "text-center",
                        render: function(data) {
                            let stars = '';
                            for (let i = 1; i <= 5; i++) {
                                stars += `<i class="bi bi-star-fill ${i <= data ? 'text-warning' : 'text-secondary'}"></i>`;
                            }
                            return stars + ` (${data}/5)`;
                        }
                    },
                    { 
                        data: "laporan.status", 
                        className: "text-center",
                        render: function(data) {
                            let badgeClass = '';
                            switch(data) {
                                case 'PENDING':
                                    badgeClass = 'bg-secondary';
                                    break;
                                case 'DIPROSES':
                                    badgeClass = 'bg-primary';
                                    break;
                                case 'SELESAI':
                                    badgeClass = 'bg-success';
                                    break;
                                case 'DITOLAK':
                                    badgeClass = 'bg-danger';
                                    break;
                                default:
                                    badgeClass = 'bg-dark';
                            }
                            return `<span class="badge ${badgeClass}">${data}</span>`;
                        }
                    },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush