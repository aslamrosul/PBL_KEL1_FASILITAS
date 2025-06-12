@empty($periode)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data periode tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ secure_url('/periode/' . $periode->periode_id . '/update_ajax') }}" method="POST" id="form-edit-periode">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Kode Periode</label>
                        <input value="{{ $periode->periode_kode }}" type="text" name="periode_kode" id="periode_kode" class="form-control" required>
                        <small id="error-periode_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Periode</label>
                        <input value="{{ $periode->periode_nama }}" type="text" name="periode_nama" id="periode_nama" class="form-control" required>
                        <small id="error-periode_nama" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Tanggal Mulai</label>
                        <input value="{{ $periode->tanggal_mulai }}" type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                        <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Tanggal Selesai</label>
                        <input value="{{ $periode->tanggal_selesai }}" type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                        <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Status Aktif</label>
                        <select name="is_aktif" id="is_aktif" class="form-select" required>
                            <option value="1" {{ $periode->is_aktif ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$periode->is_aktif ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        <small id="error-is_aktif" class="error-text form-text text-danger"></small>
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
            $("#form-edit-periode").on('submit', function(e) {
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
                            dataPeriode.ajax.reload(null, false);
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