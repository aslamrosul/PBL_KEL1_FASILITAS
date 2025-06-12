@php
     $laporan = $riwayat->laporan ?? null;
@endphp

@empty($laporan)
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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Detail Laporan & Perbaikan </h5>
                    {{-- <span class="badge 
                        @if ($laporan->status == 'Menunggu') bg-warning
                        @elseif ($laporan->status == 'Diterima') bg-info
                        @elseif ($laporan->status == 'Diproses') bg-primary
                        @elseif ($laporan->status == 'Selesai') bg-success
                        @elseif ($laporan->status == 'Ditolak') bg-danger
                        @else bg-secondary @endif">
                        {{ ucfirst($laporan->status) }}
                    </span> --}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap"> {{-- Added a flex container here --}}
                    <div class="col-md-6 p-2"> {{-- Added padding for spacing --}}
                        <h5>Informasi Laporan</h5>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th width="20%">ID Laporan</th>
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
                                        @elseif ($laporan->status == 'Diterima') bg-info
                                        @elseif ($laporan->status == 'Diproses') bg-primary
                                        @elseif ($laporan->status == 'Selesai') bg-success
                                        @elseif ($laporan->status == 'Ditolak') bg-danger
                                        @else bg-secondary @endif">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Lapor</th>
                                <td>{{ $laporan->tanggal_lapor ? $laporan->tanggal_lapor->format('d-m-Y H:i') : '-' }}</td>
                            </tr>
                            @if ($laporan->tanggal_selesai)
                                <tr>
                                    <th>Tanggal Selesai</th>
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
                                    <th>Foto Bukti Kerusakan</th>
                                    <td>
                                        <div class="text-center">
                                            <img src="{{ url('storage/' . $laporan->foto_path) }}" class="img-fluid rounded" style="max-height: 300px;">
                                            <p class="text-muted mt-2">Foto bukti kerusakan dari pelapor</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <div class="col-md-6 p-2"> {{-- Added padding for spacing --}}
                        @if ($laporan->perbaikans->isNotEmpty())
                            <h5>Detail Perbaikan</h5>
                            @foreach ($laporan->perbaikans as $perbaikan)
                                <div class="card mb-3">
                                    
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">ID Perbaikan</th>
                                                        <td>{{ $perbaikan->perbaikan_id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Teknisi</th>
                                                        <td>{{ $perbaikan->teknisi->nama ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">Tanggal Mulai</th>
                                                        <td>{{ $perbaikan->tanggal_mulai ? $perbaikan->tanggal_mulai->format('d-m-Y H:i') : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Selesai</th>
                                                        <td>{{ $perbaikan->tanggal_selesai ? $perbaikan->tanggal_selesai->format('d-m-Y H:i') : '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h6>Catatan Perbaikan</h6>
                                            <div class="p-3 bg-light rounded">
                                                {{ $perbaikan->catatan ?? 'Tidak ada catatan' }}
                                            </div>
                                        </div>

                                        @if ($perbaikan->foto_perbaikan)
                                            <div class="mb-4">
                                                <h6>Foto Bukti Perbaikan</h6>
                                                <div class="text-center">
                                                    <img src="{{ asset($perbaikan->foto_perbaikan) }}" class="img-fluid rounded" style="max-height: 300px;">
                                                    <p class="text-muted mt-2">Foto setelah perbaikan oleh teknisi</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($perbaikan->status == 'selesai')
                                            <div class="mb-4">
                                                <h6>Total Biaya</h6>
                                                <div class="p-3 bg-light rounded">
                                                    Rp {{ number_format($perbaikan->total_biaya, 0, ',', '.') }}
                                                </div>
                                            </div>

                                            @if ($perbaikan->details->count() > 0)
                                                <div class="mb-4">
                                                    <h6>Detail Tindakan Perbaikan</h6>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Tindakan</th>
                                                                <th>Deskripsi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($perbaikan->details as $detail)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $detail->tindakan }}</td>
                                                                    <td>{{ $detail->deskripsi ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info mt-4">
                                Belum ada data perbaikan untuk laporan ini.
                            </div>
                        @endif
                    </div>
                </div> {{-- End of flex container --}}

                @if ($laporan->feedback)
                    <h5 class="mt-4">Feedback Pelapor</h5>
                    <div class="card card-body bg-light">
                        <p><strong>Rating:</strong> {{ $laporan->feedback->rating ?? '-' }} bintang</p>
                        <p><strong>Komentar:</strong> {{ $laporan->feedback->komentar ?? '-' }}</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty