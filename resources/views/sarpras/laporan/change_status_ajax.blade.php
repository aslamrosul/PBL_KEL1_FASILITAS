<form action="{{ secure_url('/sarpras/laporan/' . $laporan->laporan_id . '/update_status') }}" method="POST"
    id="form-change-status">
    @csrf
    @method('PUT') {{-- Gunakan metode PUT untuk update --}}
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    Anda akan mengubah status laporan: <strong>{{ $laporan->judul }}</strong>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Status Saat Ini</label>
                    <input type="text" class="form-control" value="{{ ucfirst($laporan->status) }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Ubah Ke Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">- Pilih Status Baru -</option>
                        <option value="diterima" {{ $laporan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3" id="alasan_penolakan_group"
                  >
                    <label for="alasan_penolakan">Alasan Penolakan</label>
                    <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan"
                        rows="3">{{ $laporan->alasan_penolakan }}</textarea>
                    <small id="error-alasan_penolakan" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#form-change-status").on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);
            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status) {
                        $('.modal').modal('hide');
                        alert(response.message); // Ganti dengan SweetAlert jika ada
                        // Reload DataTable laporan
                        if (typeof dataLaporan !== 'undefined') {
                            dataLaporan.ajax.reload(null, false);
                        }
                    } else {
                        $('.error-text').text('');
                        if (response.msgField) {
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                        alert('Gagal: ' + response.message); // Ganti dengan SweetAlert jika ada
                    }
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('.error-text').text('');
                    if (errors) {
                        $.each(errors, function (prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                    }
                    alert('Terjadi kesalahan: ' + (xhr.responseJSON.message || 'Unknown error')); // Ganti dengan SweetAlert jika ada
                }
            });
        });
    });
</script>