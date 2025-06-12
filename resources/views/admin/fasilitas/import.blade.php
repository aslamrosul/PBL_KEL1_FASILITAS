@csrf
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Import Data Fasilitas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <form action="{{ secure_url('/fasilitas/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Download Template</label>
                    <a href="{{ secure_asset('template_fasilitas.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="bi bi-file-excel"></i> Download
                    </a>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih File Excel</label>
                    <input type="file" name="file_fasilitas" id="file_fasilitas" class="form-control" required>
                    <small id="error-file_fasilitas" class="error-text form-text text-danger"></small>
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
    jQuery(document).ready(function() {
        jQuery("#form-import").validate({
            rules: {
                file_fasilitas: { required: true, extension: "xlsx" },
            },
            submitHandler: function(form) {
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
                    beforeSend: function() {
                        jQuery('.btn-primary').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
                    },
                    success: function(response) {
                        jQuery('.btn-primary').prop('disabled', false).html('Import Data');

                        if (response.status) {
                            var modal = bootstrap.Modal.getInstance(document.getElementByClassName('modal'));
                            if (modal) modal.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });

                            if (typeof dataFasilitas !== 'undefined') {
                                dataFasilitas.ajax.reload(null, false);
                            }
                        } else {
                            jQuery('.error-text').text('');
                            if (response.msgField) {
                                jQuery.each(response.msgField, function(prefix, val) {
                                    jQuery('#error-' + prefix).text(val[0]);
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
                        jQuery('.btn-primary').prop('disabled', false).html('Import Data');
                        jQuery('.error-text').text('');

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            jQuery.each(xhr.responseJSON.errors, function(prefix, val) {
                                jQuery('#error-' + prefix).text(val[0]);
                            });
                        }

                        Swal.fire({
                            icon: 'error'),
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
                jQuery(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                jQuery(element).removeClass('is-invalid');
            }
        });
    });
</script>