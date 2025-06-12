@empty($klasifikasi)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data klasifikasi tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/klasifikasi/' . $klasifikasi->klasifikasi_id . '/update_ajax') }}" method="POST" id="form-edit-klasifikasi">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Klasifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Kode Klasifikasi</label>
                        <input value="{{ $klasifikasi->klasifikasi_kode }}" type="text" name="klasifikasi_kode" id="klasifikasi_kode" class="form-control" maxlength="10" required>
                        <small id="error-klasifikasi_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Klasifikasi</label>
                        <input value="{{ $klasifikasi->klasifikasi_nama }}" type="text" name="klasifikasi_nama" id="klasifikasi_nama" class="form-control" maxlength="100" required>
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
            $("#form-edit-klasifikasi").on('submit', function(e) {
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
                            // Pastikan kamu punya variabel dataKlasifikasi untuk reload DataTable
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
@endempty
