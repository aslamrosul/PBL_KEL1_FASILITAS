@empty($ruang)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data tidak ditemukan</div>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Ruang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID Ruang</th>
                        <td>{{ $ruang->ruang_id }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>
                            {{ $ruang->lantai->gedung->gedung_nama ?? '-' }} - 
                            Lantai {{ $ruang->lantai->lantai_nomor }}
                        </td>
                    </tr>
                    <tr>
                        <th>Kode Ruang</th>
                        <td>{{ $ruang->ruang_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ruang</th>
                        <td>{{ $ruang->ruang_nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty