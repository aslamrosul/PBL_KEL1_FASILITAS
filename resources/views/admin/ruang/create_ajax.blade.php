<form action="{{ url('/ruang/store_ajax') }}" method="POST" id="form-create-ruang">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Ruang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Lantai</label>
                    <select name="lantai_id" id="lantai_id" class="form-select" required>
                        <option value="">Pilih Lantai</option>
                        @foreach($lantais as $lantai)
                            <option value="{{ $lantai->lantai_id }}">
                                {{ $lantai->gedung->gedung_nama ?? '-' }} - Lantai {{ $lantai->lantai_nomor }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-lantai_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Kode Ruang</label>
                    <input type="text" name="ruang_kode" id="ruang_kode" class="form-control" required>
                    <small id="error-ruang_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Nama Ruang</label>
                    <input type="text" name="ruang_nama" id="ruang_nama" class="form-control" required>
                    <small id="error-ruang_nama" class="error-text form-text text-danger"></small>
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
        $("#form-create-ruang").on('submit', function(e) {
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
                            text: 'Data berhasil ditambahkan',
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