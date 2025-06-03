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
                    <label for="bobot_id" class="form-label">Prioritas</label>
                    <select class="form-control" id="bobot_id" name="bobot_id">
                        <option value="">Pilih Prioritas</option>
                        @foreach ($bobot as $item)
                            <option value="{{ $item->bobot_id }}">{{ $item->nama_bobot }}</option>
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