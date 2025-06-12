@empty($laporan)
    {{-- Tampilan jika data laporan tidak ditemukan --}}
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data laporan tidak ditemukan.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@else
    {{-- Tampilan detail laporan jika data ditemukan --}}
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Laporan #{{ $laporan->laporan_id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>ID Laporan</th>
                        <td>{{ $laporan->laporan_id }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>{{ $laporan->judul }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $laporan->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th>Pelapor</th>
                        <td>{{ $laporan->user->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td>{{ $laporan->periode->periode_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Fasilitas</th>
                        <td>{{ $laporan->fasilitas->fasilitas_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Gedung</th>
                        <td>{{ $laporan->fasilitas->ruang->lantai->gedung->gedung_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Lantai</th>
                        <td>{{ $laporan->fasilitas->ruang->lantai->lantai_nomor ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ruang</th>
                        <td>{{ $laporan->fasilitas->ruang->ruang_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Barang</th>
                        <td>{{ $laporan->fasilitas->barang->barang_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Bobot Prioritas</th>
                        <td>{{ $laporan->bobotPrioritas->bobot_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge
                                @if ($laporan->status == 'Menunggu') bg-warning
                                @elseif ($laporan->status == 'Diterima') bg-primary
                                @elseif ($laporan->status == 'Ditolak') bg-danger
                                @elseif ($laporan->status == 'Diproses') bg-info
                                @elseif ($laporan->status == 'Selesai') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($laporan->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Lapor</th>
                        {{-- Perbaikan: Cek apakah tanggal_lapor tidak null sebelum memformat --}}
                        <td>{{ $laporan->tanggal_lapor ? $laporan->tanggal_lapor->format('d-m-Y H:i') : '-' }}</td>
                    </tr>
                    @if ($laporan->tanggal_selesai)
                        <tr>
                            <th>Tanggal Selesai</th>
                            {{-- Perbaikan: Cek apakah tanggal_selesai tidak null sebelum memformat --}}
                            <td>{{ $laporan->tanggal_selesai ? $laporan->tanggal_selesai->format('d-m-Y H:i') : '-' }}</td>
                        </tr>
                    @endif
                    @if ($laporan->alasan_penolakan)
                        <tr>
                            <th>Alasan Penolakan</th>
                            <td>{{ $laporan->alasan_penolakan }}</td>
                        </tr>
                    @endif
                    @if ($laporan->foto_path)
                        <tr>
                            <th>Foto</th>
                            <td>
                                <a href="{{ asset('storage/' . $laporan->foto_path) }}" target="_blank">Lihat Foto</a>
                            </td>
                        </tr>
                    @endif
                </table>

                

                {{-- Bagian untuk Perbaikan (jika ada) --}}
                @if ($laporan->perbaikans->isNotEmpty())
                    <h6 class="mt-4">Detail Perbaikan:</h6>
                    <ul class="list-group">
                        @foreach ($laporan->perbaikans as $perbaikan)
                            <li class="list-group-item">
                                <strong>Deskripsi:</strong> {{ $perbaikan->catatan }}<br>
                                <strong>Tanggal Perbaikan:</strong>
                                {{-- Perbaikan: Cek apakah tanggal_perbaikan tidak null sebelum memformat --}}
                                {{ $perbaikan->tanggal_mulai ? $perbaikan->tanggal_mulai->format('d-m-Y H:i') : '-' }}<br>
                                @if ($perbaikan->foto_perbaikan)
                                    <strong>Foto Perbaikan:</strong> <a href="{{ asset('storage/' . $perbaikan->foto_perbaikan) }}" target="_blank">Lihat Foto</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- Bagian untuk Feedback (jika ada) --}}
                @if ($laporan->feedback)
                    <h6 class="mt-4">Feedback Pelapor:</h6>
                    <div class="card card-body bg-light">
                        <p><strong>Rating:</strong> {{ $laporan->feedback->rating ?? '-' }} bintang</p>
                        <p><strong>Komentar:</strong> {{ $laporan->feedback->komentar ?? '-' }}</p>
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                 @if($laporan->status === 'selesai' && !$laporan->feedback && $laporan->user_id == Auth::id())Add commentMore actions
                <a href="{{ route('pelapor.feedback.create', $laporan->laporan_id) }}" class="btn btn-primary">
                    <i class="bi bi-star-fill me-1"></i> Beri Umpan Balik
                </a>
            @elseif($laporan->status === 'selesai' && $laporan->feedback)
                <a href="{{ route('pelapor.feedback.show', $laporan->laporan_id) }}" class="btn btn-outline-primary">
                    <i class="bi bi-star-fill me-1"></i> Lihat Umpan Balik
                </a>
            @endif
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty
