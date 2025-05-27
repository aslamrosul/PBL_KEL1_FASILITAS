@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/sarpras/laporan') }}" class="btn btn-sm btn-default">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('/sarpras/laporan/'.$laporan->laporan_id) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Judul Laporan</label>
                    <input type="text" class="form-control" value="{{ $laporan->judul }}" readonly>
                </div>
                
                <div class="form-group">
                    <label>Pelapor</label>
                    <input type="text" class="form-control" value="{{ $laporan->user->nama }}" readonly>
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                
                <div class="form-group" id="alasan_penolakan_group" style="display: none;">
                    <label for="alasan_penolakan">Alasan Penolakan</label>
                    <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="3">{{ $laporan->alasan_penolakan }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Prioritas</label>
                    <select class="form-control" id="bobot_id" name="bobot_id" required>
                        <option value="">Pilih Prioritas</option>
                        @foreach($bobots as $bobot)
                            <option value="{{ $bobot->bobot_id }}" {{ $laporan->bobot_id == $bobot->bobot_id ? 'selected' : '' }}>
                                {{ $bobot->bobot_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Tampilkan/sembunyikan alasan penolakan berdasarkan status
            function toggleAlasanPenolakan() {
                if ($('#status').val() == 'ditolak') {
                    $('#alasan_penolakan_group').show();
                    $('#alasan_penolakan').prop('required', true);
                } else {
                    $('#alasan_penolakan_group').hide();
                    $('#alasan_penolakan').prop('required', false);
                }
            }
            
            // Panggil fungsi saat halaman dimuat
            toggleAlasanPenolakan();
            
            // Panggil fungsi saat status berubah
            $('#status').change(function() {
                toggleAlasanPenolakan();
            });
        });
    </script>
@endpush