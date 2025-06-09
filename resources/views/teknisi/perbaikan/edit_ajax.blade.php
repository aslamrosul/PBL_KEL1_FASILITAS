<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Proses Perbaikan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ url('/teknisi/perbaikan/' . $perbaikan->perbaikan_id . '/update_ajax') }}" method="POST"
            id="form-edit-perbaikan" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="fw-bold">Status Perbaikan</label>
                    @if (in_array($perbaikan->status, ['menunggu', 'diproses']))
                        <select name="status" id="status" class="form-control" required>
                            <option value="selesai">Selesai</option>
                        </select>
                    @else
                        <input type="text" class="form-control" value="{{ $perbaikan->status }}" readonly>
                        <input type="hidden" name="status" value="{{ $perbaikan->status }}">
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3">{{ $perbaikan->catatan }}</textarea>
                </div>

                <div id="selesai-container" style="display: {{ $perbaikan->status == 'selesai' ? 'block' : 'none' }};">
                    <div class="form-group mb-3">
                        <label>Foto Perbaikan</label>
                        <input type="file" name="foto_perbaikan" class="form-control">
                        <small class="text-muted">Upload foto setelah perbaikan (max 2MB, format: jpeg,png,jpg)</small>
                        @if ($perbaikan->foto_perbaikan)
                            <div class="mt-2">
                                <img src="{{ asset($perbaikan->foto_perbaikan) }}" class="img-thumbnail"
                                    style="max-height: 150px;">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="hapus_foto" id="hapus_foto" class="form-check-input">
                                    <label for="hapus_foto" class="form-check-label">Hapus foto saat disimpan</label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label>Total Biaya (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="total_biaya" class="form-control"
                            value="{{ $perbaikan->total_biaya ?? '' }}" required>
                    </div>

                    <h5 class="border-bottom pb-2">Detail Perbaikan</h5>
                    <div id="tindakan-container">
                        @if ($perbaikan->status == 'selesai' && $perbaikan->details->count() > 0)
                            @foreach ($perbaikan->details as $index => $detail)
                                <div class="tindakan-item mb-3 border p-3">
                                    <div class="form-group">
                                        <label>Tindakan <span class="text-danger">*</span></label>
                                        <input type="text" name="tindakan[]" class="form-control"
                                            value="{{ $detail->tindakan }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi[]" class="form-control">{{ $detail->deskripsi }}</textarea>
                                    </div>
                                    @if ($index > 0)
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-tindakan">Hapus
                                            Tindakan</button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="tindakan-item mb-3 border p-3">
                                <div class="form-group">
                                    <label>Tindakan <span class="text-danger">*</span></label>
                                    <input type="text" name="tindakan[]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi[]" class="form-control"></textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="tambah-tindakan" class="btn btn-secondary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Tindakan
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Toggle tampilan field berdasarkan status
        $('#status').change(function() {
            const status = $(this).val();
            if (status === 'selesai') {
                $('#selesai-container').show();
                $('input[name="tindakan[]"]').prop('required', true);
                $('input[name="total_biaya"]').prop('required', true);
            } else {
                $('#selesai-container').hide();
                $('input[name="tindakan[]"]').prop('required', false);
                $('input[name="total_biaya"]').prop('required', false);
            }
        });

        // Inisialisasi status saat pertama kali load
        $('#status').trigger('change');

        // Fungsi tambah tindakan
        $('#tambah-tindakan').click(function() {
            var newItem = `
                <div class="tindakan-item mb-3 border p-3">
                    <div class="form-group">
                        <label>Tindakan <span class="text-danger">*</span></label>
                        <input type="text" name="tindakan[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi[]" class="form-control"></textarea>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-tindakan">Hapus Tindakan</button>
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