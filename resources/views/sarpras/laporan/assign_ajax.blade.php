<form action="{{ secure_url('/sarpras/laporan/' . $laporan->laporan_id . '/assign') }}" method="POST" id="form-assign">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Penugasan Teknisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    Anda akan menugaskan teknisi untuk laporan: <strong>{{ $laporan->judul }}</strong>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Pilih Teknisi</label>
                    <select name="teknisi_id" id="teknisi_id" class="form-select" required>
                        <option value="">- Pilih Teknisi -</option>
                        @foreach($teknisi as $t)
                            <option value="{{ $t->user_id }}">{{ $t->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-teknisi_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="3"></textarea>
                    <small id="error-catatan" class="error-text form-text text-danger"></small>
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
        $("#form-assign").on('submit', function(e) {
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
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        dataLaporan.ajax.reload(null, false);
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