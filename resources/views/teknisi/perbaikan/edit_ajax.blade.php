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
                    <select name="status" id="status" class="form-control" required>
                        <option value="menunggu" {{ $perbaikan->status == 'menunggu' ? 'selected' : '' }}>Menunggu
                        </option>
                        <option value="diproses" {{ $perbaikan->status == 'diproses' ? 'selected' : '' }}>Diproses
                        </option>
                        <option value="selesai" {{ $perbaikan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $perbaikan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="form-group mb-3" id="catatan-container">
                    <label>Catatan <span class="text-danger" id="catatan-required"
                            style="display: none;">*</span></label>
                    <textarea name="catatan" class="form-control" rows="3">{{ $perbaikan->catatan }}</textarea>
                    <small class="text-muted">Wajib diisi ketika status Ditolak</small>
                </div>

                <div id="foto-container" style="display: {{ $perbaikan->status == 'selesai' ? 'block' : 'none' }};">
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
                </div>

                <div id="detail-perbaikan" style="display: {{ $perbaikan->status == 'selesai' ? 'block' : 'none' }};">
                    <h5 class="border-bottom pb-2">Detail Perbaikan</h5>
                    <div id="tindakan-container">
                        @if ($perbaikan->status == 'selesai' && $perbaikan->details->count() > 0)
                            @foreach ($perbaikan->details as $index => $detail)
                                <div class="tindakan-item mb-3 border p-3">
                                    <div class="form-group">
                                        <label>Tindakan <span class="text-danger">*</span></label>
                                        <input type="text" name="tindakan[]" class="form-control"
                                            value="{{ $detail->tindakan }}"
                                            {{ $perbaikan->status == 'selesai' ? 'required' : '' }}>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi[]" class="form-control">{{ $detail->deskripsi }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bahan</label>
                                                <input type="text" name="bahan[]" class="form-control"
                                                    value="{{ $detail->bahan }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Biaya (Rp)</label>
                                                <input type="number" name="biaya[]" class="form-control"
                                                    value="{{ $detail->biaya }}">
                                            </div>
                                        </div>
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
                                    <input type="text" name="tindakan[]" class="form-control"
                                        {{ $perbaikan->status == 'selesai' ? 'required' : '' }}>
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

            // Tampilkan catatan wajib jika status ditolak
            if (status === 'ditolak') {
                $('#catatan-required').show();
                $('textarea[name="catatan"]').prop('required', true);
            } else {
                $('#catatan-required').hide();
                $('textarea[name="catatan"]').prop('required', false);
            }

            // Tampilkan foto dan detail perbaikan hanya untuk status selesai
            if (status === 'selesai') {
                $('#foto-container').show();
                $('#detail-perbaikan').show();
                // Set required hanya untuk status selesai
                $('input[name="tindakan[]"]').prop('required', true);
            } else {
                $('#foto-container').hide();
                $('#detail-perbaikan').hide();
                // Hapus required ketika bukan status selesai
                $('input[name="tindakan[]"]').prop('required', false);
            }

            // Sembunyikan foto jika status ditolak
            if (status === 'ditolak') {
                $('#hapus_foto').prop('checked', true);
            }
        });

        // Inisialisasi status saat pertama kali load
        $('#status').trigger('change');

        // Fungsi tambah tindakan
        $('#tambah-tindakan').click(function() {
            var isSelesai = $('#status').val() === 'selesai';
            var newItem = `
        <div class="tindakan-item mb-3 border p-3">
            <div class="form-group">
                <label>Tindakan <span class="text-danger">*</span></label>
                <input type="text" name="tindakan[]" class="form-control" ${isSelesai ? 'required' : ''}>
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
