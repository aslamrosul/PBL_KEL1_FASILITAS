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
                    @if ($perbaikan->status === 'dalam_antrian')
                        <select name="status" id="status" class="form-control" required>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    @elseif ($perbaikan->status === 'diproses')
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

                <div id="selesai-container" style="display: {{ $perbaikan->status === 'selesai' ? 'block' : 'none' }};">
                    <div class="form-group mb-3">
                        <label>Foto Perbaikan</label>
                        <input type="file" name="foto_perbaikan" class="form-control" {{ $perbaikan->status === 'diproses' ? 'disabled' : '' }}>
                        <small class="text-muted">Upload foto setelah perbaikan (max 2MB, format: jpeg,png,jpg)</small>
                        @if ($perbaikan->foto_perbaikan)
                            <div class="mt-2">
                                <img src="{{ asset($perbaikan->foto_perbaikan) }}" class="img-thumbnail"
                                    style="max-height: 150px;">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="hapus_foto" id="hapus_foto" class="form-check-input" {{ $perbaikan->status === 'diproses' ? 'disabled' : '' }}>
                                    <label for="hapus_foto" class="form-check-label">Hapus foto saat disimpan</label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label>Total Biaya (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="total_biaya" class="form-control"
                            value="{{ $perbaikan->total_biaya ?? '' }}" {{ $perbaikan->status === 'diproses' ? 'disabled' : 'required' }}>
                    </div>

                    <h5 class="border-bottom pb-2">Detail Perbaikan</h5>
                    <div id="tindakan-container">
                        @if ($perbaikan->status === 'selesai' && $perbaikan->details->count() > 0)
                            @foreach ($perbaikan->details as $index => $detail)
                                <div class="tindakan-item mb-3 border p-3">
                                    <div class="form-group">
                                        <label>Tindakan <span class="text-danger">*</span></label>
                                        <input type="text" name="tindakan[]" class="form-control"
                                            value="{{ $detail->tindakan }}" {{ $perbaikan->status === 'diproses' ? 'disabled' : 'required' }}>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi[]" class="form-control" {{ $perbaikan->status === 'diproses' ? 'disabled' : '' }}>{{ $detail->deskripsi }}</textarea>
                                    </div>
                                    @if ($index > 0)
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-tindakan" {{ $perbaikan->status === 'diproses' ? 'disabled' : '' }}>Hapus Tindakan</button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="tindakan-item mb-3 border p-3">
                                <div class="form-group">
                                    <label>Tindakan <span class="text-danger">*</span></label>
                                    <input type="text" name="tindakan[]" class="form-control" {{ $perbaikan->status === 'diproses' ? 'disabled' : 'required' }}>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi[]" class="form-control" {{ $perbaikan->status === 'diproses' ? 'disabled' : '' }}></textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="tambah-tindakan" class="btn btn-secondary btn-sm" {{ $perbaikan->status === 'diproses' ? 'disabled' : '' }}>
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
            $('input[name="tindakan[]"]').prop('required', true).prop('disabled', false);
            $('textarea[name="deskripsi[]"]').prop('disabled', false);
            $('input[name="total_biaya"]').prop('required', true).prop('disabled', false);
            $('input[name="foto_perbaikan"]').prop('disabled', false);
            $('#tambah-tindakan').prop('disabled', false);
            $('.remove-tindakan').prop('disabled', false);
        } else {
            $('#selesai-container').hide();
            $('input[name="tindakan[]"]').prop('required', false).prop('disabled', true);
            $('textarea[name="deskripsi[]"]').prop('disabled', true);
            $('input[name="total_biaya"]').prop('required', false).prop('disabled', true);
            $('input[name="foto_perbaikan"]').prop('disabled', true);
            $('#tambah-tindakan').prop('disabled', true);
            $('.remove-tindakan').prop('disabled', true);
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