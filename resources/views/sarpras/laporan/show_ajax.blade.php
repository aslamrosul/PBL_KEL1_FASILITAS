<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Laporan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
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
                    <td>{{ $laporan->user->nama }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>{{ $laporan->periode->periode_nama }}</td>
                </tr>
                <tr>
                    <th>Fasilitas</th>
                    <td>{{ $laporan->fasilitas->fasilitas_nama }}</td>
                </tr>
                <tr>
                    <th>Prioritas</th>
                    <td>{{ $laporan->bobotPrioritas->bobot_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge 
                            @if($laporan->status == 'pending') bg-secondary
                            @elseif($laporan->status == 'diverifikasi') bg-info
                            @elseif($laporan->status == 'diproses') bg-primary
                            @elseif($laporan->status == 'selesai') bg-success
                            @else bg-danger @endif">
                            {{ ucfirst($laporan->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Lapor</th>
                    <td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>