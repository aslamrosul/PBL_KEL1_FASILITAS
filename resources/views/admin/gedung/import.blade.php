@csrf
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Import Data Gedung</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <form action="{{ secure_url('/gedung/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Download Template</label>
                    <a href="{{ secure_asset('template_gedung.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="bi bi-file-excel"></i> Download
                    </a>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih File</label>
                    <input type="file" name="file_gedung" id="file_gedung" class="form-control" required>
                    <small id="error-file_gedung" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Import Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form-import").validate({
            rules: {
                file_gedung: { required: true, extension: "xlsx" },
            },
            submitHandler: function(form) {
                var formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.btn-primary').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
                    },
                    success: function(response) {
                        $('.btn-primary').prop('disabled', false).html('Import Data');

                        if (response.status) {
                            var modal = bootstrap.Modal.getInstance(document.getElementById('myModal'));
                            if (modal) modal.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });

                            if (typeof dataGedung !== 'undefined') {
                                dataGedung.ajax.reload(null, false);
                            }
                        } else {
                            $('.error-text').text('');
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            if (response.errors) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Beberapa Data Gagal',
                                    html: response.errors.join('<br>')
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        $('.btn-primary').prop('disabled', false).html('Import Data');
                        $('.error-text').text('');

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengimport data'
                        });
                    }
                });

                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>