@empty($kriteria)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data kriteria tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID Kriteria</th>
                        <td>{{ $kriteria->kriteria_id }}</td>
                    </tr>
                    <tr>
                        <th>Kode Kriteria</th>
                        <td>{{ $kriteria->kriteria_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kriteria</th>
                        <td>{{ $kriteria->kriteria_nama }}</td>
                    </tr>
                    <tr>
                        <th>Bobot</th>
                        <td>{{ $kriteria->bobot }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty