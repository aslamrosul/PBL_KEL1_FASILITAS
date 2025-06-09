@empty($laporan)
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data laporan tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pelapor/laporan/' . $laporan->laporan_id . '/update_ajax') }}" method="POST" id="form-edit-laporan" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Laporan</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $laporan->judul }}" required>
                        <small id="error-judul" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $laporan->deskripsi }}</textarea>
                        <small id="error-deskripsi" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="periode_id" class="form-label">Periode</label>
                        <select class="form-control" id="periode_id" name="periode_id" required>
                            <option value="">Pilih Periode</option>
                            @foreach ($periode as $item)
                                <option value="{{ $item->periode_id }}" {{ $item->periode_id == $laporan->periode_id ? 'selected' : '' }}>
                                    {{ $item->periode_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-periode_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="fasilitas_id" class="form-label">Fasilitas</label>
                        <select class="form-control" id="fasilitas_id" name="fasilitas_id" required>
                            <option value="">Pilih Fasilitas</option>
                            @foreach ($fasilitas as $item)
                                <option value="{{ $item->fasilitas_id }}" {{ $item->fasilitas_id == $laporan->fasilitas_id ? 'selected' : '' }}>
                                    {{ $item->fasilitas_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-fasilitas_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="bobot_id" class="form-label">Prioritas</label>
                        <select class="form-control" id="bobot_id" name="bobot_id">
                            <option value="">Pilih Prioritas</option>
                            @foreach ($bobot as $item)
                                <option value="{{ $item->bobot_id }}" {{ $item->bobot_id == $laporan->bobot_id ? 'selected' : '' }}>
                                    {{ $item->nama_bobot }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-bobot_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto (Opsional)</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small id="error-foto" class="text-danger error-text"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#form-edit-laporan').on('submit', function(e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);
                $('.error-text').text('');
                $.ajax({
                    url: form.action,
                    method: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('.modal').modal('hide');
                            window.dataLaporan.ajax.reload(null, false);
                            Swal.fire('Berhasil', response.message, 'success');
                        } else {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                    }
                });
            });
        });
    </script>
@endempty