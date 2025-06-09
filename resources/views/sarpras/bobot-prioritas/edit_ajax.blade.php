@empty($bobot)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data bobot prioritas tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/sarpras/bobot-prioritas/' . $bobot->bobot_id . '/update_ajax') }}" method="POST" id="form-edit-bobot">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Skor Bobot Prioritas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Kode Bobot</label>
                        <input value="{{ $bobot->bobot_kode }}" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Bobot</label>
                        <input value="{{ $bobot->bobot_nama }}" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>Skor Minimum</label>
                        <input type="number" name="skor_min" id="skor_min" class="form-control" value="{{ $bobot->skor_min }}" required>
                        <small id="error-skor_min" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Skor Maksimum</label>
                        <input type="number" name="skor_max" id="skor_max" class="form-control" value="{{ $bobot->skor_max }}" required>
                        <small id="error-skor_max" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Tindakan</label>
                        <input value="{{ $bobot->tindakan }}" type="text" class="form-control" readonly>
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
            $("#form-edit-bobot").on('submit', function(e) {
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
                            $('#table_bobot_prioritas').DataTable().ajax.reload(null, false);
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