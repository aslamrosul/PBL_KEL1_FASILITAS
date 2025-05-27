@empty($fasilitas)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data fasilitas tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/fasilitas/' . $fasilitas->fasilitas_id . '/update_ajax') }}" method="POST" id="form-edit-fasilitas">
        @csrf
        @method('PUT')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Fasilitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Ruang</label>
                        <select name="ruang_id" id="ruang_id" class="form-control" required>
                            <option value="">Pilih Ruang</option>
                            @foreach($ruangs as $ruang)
                                <option value="{{ $ruang->ruang_id }}" {{ $fasilitas->ruang_id == $ruang->ruang_id ? 'selected' : '' }}>{{ $ruang->ruang_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-ruang_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Barang</label>
                        <select name="barang_id" id="barang_id" class="form-control" required>
                            <option value="">Pilih Barang</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->barang_id }}" {{ $fasilitas->barang_id == $barang->barang_id ? 'selected' : '' }}>{{ $barang->barang_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-barang_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kode Fasilitas</label>
                        <input value="{{ $fasilitas->fasilitas_kode }}" type="text" name="fasilitas_kode" id="fasilitas_kode" class="form-control" maxlength="20" required>
                        <small id="error-fasilitas_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Fasilitas</label>
                        <input value="{{ $fasilitas->fasilitas_nama }}" type="text" name="fasilitas_nama" id="fasilitas_nama" class="form-control" maxlength="100" required>
                        <small id="error-fasilitas_nama" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control">{{ $fasilitas->keterangan }}</textarea>
                        <small id="error-keterangan" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="baik" {{ $fasilitas->status == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ $fasilitas->status == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ $fasilitas->status == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        <small id="error-status" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group mb-3">
                        <label>Tahun Pengadaan</label>
                        <input value="{{ $fasilitas->tahun_pengadaan }}" type="number" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control" min="1900" max="{{ date('Y') }}">
                        <small id="error-tahun_pengadaan" class="error-text form-text text-danger"></small>
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
        jQuery(document).ready(function() {
            jQuery("#form-edit-fasilitas").on('submit', function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);
                jQuery.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            jQuery('.modal').modal('hide');
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Data berhasil diupdate',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            if (typeof dataFasilitas !== 'undefined') {
                                dataFasilitas.ajax.reload(null, false);
                            }
                        } else {
                            jQuery('.error-text').text('');
                            jQuery.each(response.msgField, function(prefix, val) {
                                jQuery('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        jQuery('.error-text').text('');
                        jQuery.each(errors, function(prefix, val) {
                            jQuery('#error-' + prefix).text(val[0]);
                        });
                    }
                });
            });
        });
    </script>
@endempty