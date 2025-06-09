<form action="{{ url('/sarpras/kriteria/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Kode Kriteria</label>
                    <input type="text" name="kriteria_kode" id="kriteria_kode" class="form-control" maxlength="10" required>
                    <small id="error-kriteria_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Nama Kriteria</label>
                    <input type="text" name="kriteria_nama" id="kriteria_nama" class="form-control" maxlength="100" required>
                    <small id="error-kriteria_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Bobot</label>
                    <input type="number" step="0.01" min="0" max="1" name="bobot" id="bobot" class="form-control" required>
                    <small id="error-bobot" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Jenis Kriteria</label>
                    <select name="kriteria_jenis" id="kriteria_jenis" class="form-select" required>
                        <option value="">- Pilih Jenis -</option>
                        <option value="benefit">Benefit</option>
                        <option value="cost">Cost</option>
                    </select>
                    <small id="error-kriteria_jenis" class="error-text form-text text-danger"></small>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
jQuery(document).ready(function() {
    jQuery("#form-tambah").on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        jQuery.ajax({
            url: form.action,
            type: form.method,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    jQuery('.modal').modal('hide');
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Data berhasil ditambahkan',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    if (typeof dataKriteria !== 'undefined') {
                        dataKriteria.ajax.reload(null, false);
                    }
                } else {
                    jQuery('.error-text').text('');
                    jQuery.each(response.msgField, function(prefix, val) {
                        jQuery('#error-' + prefix).text(val[0]);
                    });
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                jQuery('.error-text').text('');
                jQuery.each(errors, function(prefix, val) {
                    jQuery('#error-' + prefix).text(val[0]);
                });
            }
        });
    });
});
</script>