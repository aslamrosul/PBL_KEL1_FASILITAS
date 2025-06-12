<form action="{{ secure_url('/ruang/import_ajax') }}" method="POST" enctype="multipart/form-data" id="form-import-ruang">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Ruang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Petunjuk:</strong><br>
                    1. Download template import <a href="#">disini</a><br>
                    2. Format file harus .xlsx<br>
                    3. Kolom pertama: ID Lantai<br>
                    4. Kolom kedua: Kode Ruang<br>
                    5. Kolom ketiga: Nama Ruang<br>
                </div>
                <div class="form-group mb-3">
                    <label>File Excel</label>
                    <input type="file" name="file_ruang" id="file_ruang" class="form-control" required accept=".xlsx">
                    <small id="error-file_ruang" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-import-ruang").on('submit', function(e) {
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
                            text: 'Data berhasil diimport',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        dataRuang.ajax.reload(null, false);
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