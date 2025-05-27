<form action="{{ url('/klasifikasi/store_ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Klasifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Kode Klasifikasi</label>
                    <input type="text" name="klasifikasi_kode" id="klasifikasi_kode" class="form-control" maxlength="10" required>
                    <small id="error-klasifikasi_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Nama Klasifikasi</label>
                    <input type="text" name="klasifikasi_nama" id="klasifikasi_nama" class="form-control" maxlength="100" required>
                    <small id="error-klasifikasi_nama" class="error-text form-text text-danger"></small>
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
$(document).ready(function() {
    $("#form-tambah").on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        $.ajax({
            url: form.action,
            type: form.method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status) {
                    $('.modal').modal('hide');
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Data berhasil ditambahkan',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    // Asumsi kamu punya dataKlasifikasi DataTable
                    if(typeof dataKlasifikasi !== 'undefined'){
                        dataKlasifikasi.ajax.reload(null, false);
                    }
                } else {
                    $('.error-text').text('');
                    $.each(response.msgField, function(prefix, val) {
                        $('#error-' + prefix).text(val[0]);
                    });
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $('.error-text').text('');
                $.each(errors, function(prefix, val) {
                    $('#error-' + prefix).text(val[0]);
                });
            }
        });
    });
});
</script>
