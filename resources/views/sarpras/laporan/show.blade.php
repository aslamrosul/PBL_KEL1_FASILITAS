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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Judul Laporan</label>
                        <p class="form-control-static">{{ $laporan->judul }}</p>
                    </div>
                    <div class="form-group">
                        <label>Pelapor</label>
                        <p class="form-control-static">{{ $laporan->user->nama }}</p>
                    </div>
                    <div class="form-group">
                        <label>Periode</label>
                        <p class="form-control-static">{{ $laporan->periode->nama_periode }}</p>
                    </div>
                    <div class="form-group">
                        <label>Fasilitas</label>
                        <p class="form-control-static">{{ $laporan->fasilitas->fasilitas_nama ?? '-' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <p class="form-control-static">
                            @if($laporan->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($laporan->status == 'diterima')
                                <span class="badge bg-info">Diterima</span>
                            @elseif($laporan->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif($laporan->status == 'diproses')
                                <span class="badge bg-primary">Diproses</span>
                            @elseif($laporan->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </p>
                    </div>
                    <div class="form-group">
                        <label>Prioritas</label>
                        <p class="form-control-static">{{ $laporan->bobotPrioritas->bobot_nama ?? '-' }}</p>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Laporan</label>
                        <p class="form-control-static">{{ $laporan->created_at }}</p>
                    </div>
                    @if($laporan->status == 'ditolak')
                    <div class="form-group">
                        <label>Alasan Penolakan</label>
                        <p class="form-control-static">{{ $laporan->alasan_penolakan }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <p class="form-control-static">{{ $laporan->deskripsi }}</p>
            </div>
            @if($laporan->foto_path)
            <div class="form-group">
                <label>Foto Bukti</label>
                <div>
                    <img src="{{ asset('storage/' . $laporan->foto_path) }}" alt="Foto Bukti" class="img-fluid" style="max-height: 300px;">
                </div>
            </div>
            @endif

            <hr>

            @if($laporan->status == 'diterima')
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tugaskan Teknisi</h3>
                </div>
                <form method="POST" action="{{ url('/sarpras/laporan/'.$laporan->laporan_id.'/assign') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="teknisi_id">Teknisi</label>
                            <select class="form-control" id="teknisi_id" name="teknisi_id" required>
                                <option value="">Pilih Teknisi</option>
                                @foreach($teknisis as $teknisi)
                                    <option value="{{ $teknisi->user_id }}">{{ $teknisi->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Tugaskan</button>
                    </div>
                </form>
            </div>
            @endif

            @if($laporan->perbaikans->count() > 0)
            <div class="card card-info mt-4">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Perbaikan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Teknisi</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan->perbaikans as $perbaikan)
                                <tr>
                                    <td>{{ $perbaikan->teknisi->nama }}</td>
                                    <td>{{ $perbaikan->tanggal_mulai }}</td>
                                    <td>{{ $perbaikan->tanggal_selesai ?? '-' }}</td>
                                    <td>
                                        @if($perbaikan->status == 'diproses')
                                            <span class="badge bg-primary">Diproses</span>
                                        @elseif($perbaikan->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($perbaikan->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $perbaikan->catatan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="card card-secondary mt-4">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Aktivitas</h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($laporan->histories as $history)
                        {{-- <div class="time-label">
                            <span class="bg-info">{{ $history->created_at->format('d M Y H:i') }}</span>
                        </div> --}}
                        <div>
                            <i class="fas fa-user bg-blue"></i>
                            <div class="timeline-item">
                                {{-- <span class="time"><i class="fas fa-clock"></i> {{ $history->created_at->diffForHumans() }}</span> --}}
                                <h3 class="timeline-header">{{ $history->user->nama }}</h3>
                                <div class="timeline-body">
                                    {{ $history->keterangan }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection