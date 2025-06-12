<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Rekomendasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>Judul Laporan</th>
                    <td>{{ $laporan->judul ?? 'Tidak tersedia' }}</td>
                </tr>
                <tr>
                    <th>Pelapor</th>
                    <td>{{ $laporan->user->nama ?? 'Tidak tersedia' }}
                        ({{ $laporan->user->level->level_nama ?? 'Tidak tersedia' }})</td>
                </tr>
                <tr>
                    <th>Fasilitas</th>
                    <td>{{ $laporan->fasilitas->fasilitas_nama ?? 'Tidak tersedia' }}</td>
                </tr>
                @if($laporan->rekomendasi)
                    <tr>
                        <th>Frekuensi Laporan</th>
                        <td>{{ $laporan->rekomendasi->nilai_kriteria['frekuensi'] ?? 'Tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <th>Usia Fasilitas</th>
                        <td>{{ $laporan->rekomendasi->nilai_kriteria['usia'] ?? 'Tidak tersedia' }} tahun</td>
                    </tr>
                    <tr>
                        <th>Kondisi Fasilitas</th>
                        <td>{{ ucfirst($laporan->fasilitas->status ?? 'Tidak tersedia') }}</td>
                    </tr>
                    <tr>
                        <th>Prioritas Barang</th>
                        <td>{{ $laporan->fasilitas->barang->bobot_prioritas ?? 'Tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <th>Klasifikasi Fasilitas</th>
                        <td>{{ $laporan->fasilitas->barang->klasifikasi->klasifikasi_nama ?? 'Tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <th>Skor Prioritas</th>
                        <td>{{ $laporan->rekomendasi->skor_total ?? 'Tidak tersedia' }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Level Prioritas</th>
                    <td>
                        @if($laporan->bobotPrioritas)
                            <span class="badge bg-primary">{{ $laporan->bobotPrioritas->bobot_nama }}</span>
                        @else
                            <span class="badge bg-secondary">Belum ditentukan</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <a href="{{ url('/sarpras/rekomendasi/' . $laporan->laporan_id . '/detail-perhitungan') }}"
                class="btn btn-primary me-2">Lihat Detail AHP & TOPSIS</a>
            <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>