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
    <form action="{{ secure_url('/fasilitas/' . $fasilitas->fasilitas_id . '/delete_ajax') }}" method="POST" id="form-delete-fasilitas">
        @csrf
        @method('DELETE')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Fasilitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary">
                        Apakah Anda yakin ingin menghapus data fasilitas berikut?
                    </div>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Kode Fasilitas:</th>
                            <td>{{ $fasilitas->fasilitas_kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama Fasilitas:</th>
                            <td>{{ $fasilitas->fasilitas_nama }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>{{ $fasilitas->status }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        jQuery(document).ready(function() {
            jQuery("#form-delete-fasilitas").on('submit', function(e) {
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
                                text: 'Data berhasil dihapus',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            if (typeof dataFasilitas !== 'undefined') {
                                dataFasilitas.ajax.reload(null, false);
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
@endempty