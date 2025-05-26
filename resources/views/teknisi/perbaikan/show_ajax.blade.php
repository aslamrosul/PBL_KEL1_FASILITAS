<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Perbaikan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">ID Perbaikan</th>
                            <td>{{ $perbaikan->perbaikan_id }}</td>
                        </tr>
                        <tr>
                            <th>ID Laporan</th>
                            <td>{{ $perbaikan->laporan_id }}</td>
                        </tr>
                        <tr>
                            <th>Teknisi</th>
                            <td>{{ $perbaikan->teknisi->nama }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Tanggal Mulai</th>
                            <td>{{ $perbaikan->tanggal_mulai }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>{{ $perbaikan->tanggal_selesai ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($perbaikan->status == 'menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($perbaikan->status == 'diproses')
                                    <span class="badge badge-primary">Diproses</span>
                                @elseif($perbaikan->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @elseif($perbaikan->status == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">Unknown</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mb-4">
                <h5>Informasi Laporan</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="20%">Judul Laporan</th>
                        <td>{{ $perbaikan->laporan->judul }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $perbaikan->laporan->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th>Fasilitas</th>
                        <td>{{ $perbaikan->laporan->fasilitas->fasilitas_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pelapor</th>
                        <td>{{ $perbaikan->laporan->user->nama }}</td>
                    </tr>
                </table>
            </div>

            <div class="mb-4">
                <h5>Catatan Perbaikan</h5>
                <div class="p-3 bg-light rounded">
                    {{ $perbaikan->catatan ?? 'Tidak ada catatan' }}
                </div>
            </div>

            @if($perbaikan->status == 'selesai' && $perbaikan->details->count() > 0)
                <div class="mb-4">
                    <h5>Detail Tindakan Perbaikan</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tindakan</th>
                                <th>Deskripsi</th>
                                <th>Bahan</th>
                                <th>Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perbaikan->details as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->tindakan }}</td>
                                    <td>{{ $detail->deskripsi ?? '-' }}</td>
                                    <td>{{ $detail->bahan ?? '-' }}</td>
                                    <td>{{ $detail->biaya ? 'Rp '.number_format($detail->biaya, 0, ',', '.') : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>