<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Riwayat Penugasan</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Laporan:</label>
                <p>{{ $riwayat->laporan->judul ?? '-' }}</p>
            </div>
            <div class="form-group">
                <label>Teknisi:</label>
                <p>{{ $riwayat->teknisi->nama ?? '-' }}</p>
            </div>
            <div class="form-group">
                <label>Petugas Sarpras:</label>
                <p>{{ $riwayat->sarpras->nama ?? '-' }}</p>
            </div>
            <div class="form-group">
                <label>Tanggal Penugasan:</label>
                <p>{{ $riwayat->tanggal_penugasan ? $riwayat->tanggal_penugasan->format('d-m-Y') : '-' }}</p>
            </div>
            <div class="form-group">
                <label>Status Penugasan:</label>
                <p>{{ ucfirst($riwayat->status_penugasan) }}</p>
            </div>
            <div class="form-group">
                <label>Tanggal Selesai:</label>
                <p>{{ $riwayat->tanggal_selesai ? $riwayat->tanggal_selesai->format('d-m-Y') : '-' }}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>