<form action="{{ url('/teknisi/perbaikan/' . $perbaikan->perbaikan_id . '/update_ajax') }}" method="POST" id="form-edit-perbaikan">
    @csrf
    @method('PUT')
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proses Perbaikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="menunggu" {{ $perbaikan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $perbaikan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $perbaikan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $perbaikan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control">{{ $perbaikan->catatan }}</textarea>
                </div>

                <div id="detail-perbaikan" style="display: {{ $perbaikan->status == 'selesai' ? 'block' : 'none' }};">
                    <h5>Detail Perbaikan</h5>
                    <div id="tindakan-container">
                        @if($perbaikan->status == 'selesai' && $perbaikan->details->count() > 0)
                            @foreach($perbaikan->details as $index => $detail)
                                <div class="tindakan-item mb-3 border p-3">
                                    <div class="form-group">
                                        <label>Tindakan</label>
                                        <input type="text" name="tindakan[]" class="form-control" value="{{ $detail->tindakan }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi[]" class="form-control">{{ $detail->deskripsi }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bahan</label>
                                                <input type="text" name="bahan[]" class="form-control" value="{{ $detail->bahan }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Biaya (Rp)</label>
                                                <input type="number" name="biaya[]" class="form-control" value="{{ $detail->biaya }}">
                                            </div>
                                        </div>
                                    </div>
                                    @if($index > 0)
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-tindakan">Hapus</button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="tindakan-item mb-3 border p-3">
                                <div class="form-group">
                                    <label>Tindakan</label>
                                    <input type="text" name="tindakan[]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi[]" class="form-control"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bahan</label>
                                            <input type="text" name="bahan[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Biaya (Rp)</label>
                                            <input type="number" name="biaya[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="tambah-tindakan" class="btn btn-secondary btn-sm">Tambah Tindakan</button>
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
        // Tampilkan/sembunyikan detail perbaikan berdasarkan status
        $('#status').change(function() {
            if ($(this).val() == 'selesai') {
                $('#detail-perbaikan').show();
            } else {
                $('#detail-perbaikan').hide();
            }
        });

        // Tambah tindakan
        $('#tambah-tindakan').click(function() {
            var newItem = `
                <div class="tindakan-item mb-3 border p-3">
                    <div class="form-group">
                        <label>Tindakan</label>
                        <input type="text" name="tindakan[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi[]" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bahan</label>
                                <input type="text" name="bahan[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Biaya (Rp)</label>
                                <input type="number" name="biaya[]" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-tindakan">Hapus</button>
                </div>
            `;
            $('#tindakan-container').append(newItem);
        });

        // Hapus tindakan
        $(document).on('click', '.remove-tindakan', function() {
            $(this).closest('.tindakan-item').remove();
        });

        // Submit form
        $("#form-edit-perbaikan").on('submit', function(e) {
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
                        }).then(() => {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                dataPerbaikan.ajax.reload(null, false);
                            }
                        });
                    } else {
                        Swal.fire('Gagal', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value + '<br>';
                    });
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        });
    });
</script>