@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/sarpras/laporan/export') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="periode_id">Filter Periode:</label>
                    <select class="form-control" id="periode_id" name="periode_id">
                        <option value="">Semua Periode</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->periode_id }}">{{ $periode->nama_periode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status">Filter Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="bobot_id">Filter Prioritas:</label>
                    <select class="form-control" id="bobot_id" name="bobot_id">
                        <option value="">Semua Prioritas</option>
                        @foreach($bobots as $bobot)
                            <option value="{{ $bobot->bobot_id }}">{{ $bobot->bobot_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-secondary ml-2">Reset</button>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_laporan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelapor</th>
                        <th>Judul</th>
                        <th>Periode</th>
                        <th>Fasilitas</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var dataLaporan = $('#table_laporan').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('sarpras/laporan/list') }}",
                    data: function(d) {
                        d.periode_id = $('#periode_id').val();
                        d.status = $('#status').val();
                        d.bobot_id = $('#bobot_id').val();
                    }
                },
                columns: [
                    {data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false},
                    {data: "nama_pelapor", className: "", orderable: true, searchable: true},
                    {data: "judul", className: "", orderable: true, searchable: true},
                    {data: "periode", className: "", orderable: true, searchable: true},
                    {data: "fasilitas", className: "", orderable: true, searchable: true},
                    {data: "prioritas", className: "", orderable: true, searchable: true},
                    {data: "status", className: "", orderable: true, searchable: true},
                    {data: "created_at", className: "", orderable: true, searchable: true},
                    {data: "aksi", className: "text-center", orderable: false, searchable: false}
                ]
            });

            $('#btn-filter').click(function(){
                dataLaporan.ajax.reload();
            });

            $('#btn-reset').click(function(){
                $('#periode_id').val('');
                $('#status').val('');
                $('#bobot_id').val('');
                dataLaporan.ajax.reload();
            });
        });
    </script>
@endpush