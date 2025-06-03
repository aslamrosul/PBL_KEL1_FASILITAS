<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Laporan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <p>{{ $laporan->judul }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <p>{{ $laporan->deskripsi }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Periode</label>
                <p>{{ $laporan->periode->periode_nama ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">gedung</label>
                <p>{{ $laporan->gedung->gedung_nama ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">lantai</label>
                <p>{{ $laporan->lantai->lantai_nama ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">ruang</label>
                <p>{{ $laporan->ruang->ruang_nama ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">barang</label>
                <p>{{ $laporan->barang->barang_nama ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Fasilitas</label>
                <p>{{ $laporan->fasilitas->fasilitas_nama ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Prioritas</label>
                <p>{{ $laporan->bobotPrioritas->nama_bobot ?? '-' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <p>{{ $laporan->status }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lapor</label>
                <p>{{ $laporan->tanggal_lapor }}</p>
            </div>
            @if ($laporan->foto_path)
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <img src="{{ Storage::url($laporan->foto_path) }}" alt="Foto Laporan" width="200">
                </div>
            @endif
            @if ($laporan->alasan_penolakan)
                <div class="mb-3">
                    <label class="form-label">Alasan Penolakan</label>
                    <p>{{ $laporan->alasan_penolakan }}</p>
                </div>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>