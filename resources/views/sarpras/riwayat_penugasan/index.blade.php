@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <a href="{{ route('penugasan.export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export Excel</a>
                <a href="{{ route('penugasan.export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export PDF</a>
              
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="status_penugasan" name="status_penugasan">
                                <option value="">- Semua -</option>
                                <option value="ditugaskan">Ditugaskan</option>
                                <option value="selesai">Selesai</option>
                              
                            </select>
                            <small class="text-muted">Status Penugasan</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="table_riwayat">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Laporan</th>
                            <th>Teknisi</th>
                            <th>Petugas Sarpras</th>
                            <th>Tanggal Penugasan</th>
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
    <!-- Add any additional CSS here -->
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

        var dataRiwayat;
        $(document).ready(function () {
            window.dataRiwayat = $('#table_riwayat').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ route('penugasan.list') }}",
                    type: "POST",
                    data: function (d) {
                        d.status_penugasan = $('#status_penugasan').val();
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "laporan_judul", className: "", orderable: true, searchable: true },
                    { data: "teknisi_nama", className: "", orderable: true, searchable: true },
                    { data: "sarpras_nama", className: "", orderable: true, searchable: true },
                    { data: "tanggal_penugasan", className: "", orderable: true, searchable: true },
                    { data: "status_penugasan", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "", orderable: false, searchable: false }
                ]
            });

            $('#status_penugasan').on('change', function () {
                dataRiwayat.ajax.reload();
            });
        });
    </script>
@endpush