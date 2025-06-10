<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Tambah Laporan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formLaporan" action="{{ url('/pelapor/laporan/store_ajax') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Laporan</label>
                    <input type="text" class="form-control" id="judul" name="judul" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="periode_id" class="form-label">Periode</label>
                    <select class="form-control" id="periode_id" name="periode_id" required>
                        <option value="">Pilih Periode</option>
                        @foreach ($periode as $item)
                            <option value="{{ $item->periode_id }}">{{ $item->periode_nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="fasilitas_id" class="form-label">Fasilitas</label>
                    <select class="form-control" id="fasilitas_id" name="fasilitas_id" required>
                        <option value="">Pilih Fasilitas</option>
                        @foreach ($fasilitas as $item)
                            <option value="{{ $item->fasilitas_id }}">{{ $item->fasilitas_nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="gedung_id" class="form-label">Gedung</label>
                    <select class="form-control" id="gedung_id" name="gedung_id" required>
                        <option value="">Pilih Gedung</option>
                        @foreach ($gedung as $item)
                            <option value="{{ $item->gedung_id }}">{{ $item->gedung_nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="lantai_id" class="form-label">Lantai</label>
                    <select class="form-control" id="lantai_id" name="lantai_id" required>
                        <option value="">Pilih Lantai</option>
                        @foreach ($lantai as $item)
                            <option value="{{ $item->lantai_id }}">{{ $item->lantai_nomor }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="ruang_id" class="form-label">Ruang</label>
                    <select class="form-control" id="ruang_id" name="ruang_id" required>
                        <option value="">Pilih Ruang</option>
                        @foreach ($ruang as $item)
                            <option value="{{ $item->ruang_id }}">{{ $item->ruang_nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="barang_id" class="form-label">Barang</label>
                    <select class="form-control" id="barang_id" name="barang_id" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto (Opsional)</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    jQuery('#formLaporan').on('submit', function(e) {
        e.preventDefault();
        jQuery('.invalid-feedback').empty();
        jQuery('.form-control').removeClass('is-invalid');
        jQuery.ajax({
            url: jQuery(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status) {
                    jQuery('#myModal').modal('hide');
                    window.dataLaporan.ajax.reload();
                    alert(response.message);
                } else {
                    jQuery.each(response.msgField, function(field, messages) {
                        jQuery('#' + field).addClass('is-invalid');
                        jQuery('#' + field).siblings('.invalid-feedback').text(messages[0]);
                    });
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
            }
        });
    });
</script>