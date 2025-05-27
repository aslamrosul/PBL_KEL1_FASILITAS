@empty($fasilitas)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data fasilitas tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID Fasilitas</th>
                        <td>{{ $fasilitas->fasilitas_id }}</td>
                    </tr>
                    <tr>
                        <th>Ruang</th>
                        <td>{{ $fasilitas->ruang ? $fasilitas->ruang->ruang_nama : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Barang</th>
                        <td>{{ $fasilitas->barang ? $fasilitas->barang->barang_nama : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kode Fasilitas</th>
                        <td>{{ $fasilitas->fasilitas_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Fasilitas</th>
                        <td>{{ $fasilitas->fasilitas_nama }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $fasilitas->keterangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $fasilitas->status }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Pengadaan</th>
                        <td>{{ $fasilitas->tahun_pengadaan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty