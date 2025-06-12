@empty($kategori)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data kategori tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ secure_url('/kategori/' . $kategori->kategori_id . '/update_ajax') }}" method="POST" id="form-edit-kategori">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Kode Kategori</label>
                        <input value="{{ $kategori->kategori_kode }}" type="text" name="kategori_kode" id="kategori_kode" class="form-control" required>
                        <small id="error-kategori_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Kategori</label>
                        <input value="{{ $kategori->kategori_nama }}" type="text" name="kategori_nama" id="kategori_nama" class="form-control" required>
                        <small id="error-kategori_nama" class="error-text form-text text-danger"></small>
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
            $("#form-edit-kategori").on('submit', function(e) {
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
                                text: 'Data berhasil diupdate',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            dataKategori.ajax.reload(null, false);
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
@endempty