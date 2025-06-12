<form action="{{ url('/fasilitas/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Ruang</label>
                    <select name="ruang_id" id="ruang_id" class="form-control" required>
                        <option value="">Pilih Ruang</option>
                        @foreach($ruangs as $ruang)
                            <option value="{{ $ruang->ruang_id }}">{{ $ruang->ruang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-ruang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">Pilih Barang</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Kode Fasilitas</label>
                    <input type="text" name="fasilitas_kode" id="fasilitas_kode" class="form-control" maxlength="20" required>
                    <small id="error-fasilitas_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Nama Fasilitas</label>
                    <input type="text" name="fasilitas_nama" id="fasilitas_nama" class="form-control" maxlength="100" required>
                    <small id="error-fasilitas_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                    <small id="error-keterangan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                    </select>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group mb-3">
                    <label>Tahun Pengadaan</label>
                    <input type="number" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control" min="1900" max="{{ date('Y') }}">
                    <small id="error-tahun_pengadaan" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
jQuery(document).ready(function() {
    // Debug: Check if dependencies are loaded
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded!');
        return;
    }
    if (!jQuery.fn.validate) {
        console.warn('jQuery Validate is not loaded. Loading from CDN...');
        jQuery.getScript('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js', function() {
            initializeForm();
        });
    } else {
        initializeForm();
    }

    function initializeForm() {
        console.log('Initializing form...');

        // Initialize jQuery Validate
        jQuery("#form-tambah").validate({
            rules: {
                ruang_id: { required: true },
                barang_id: { required: true },
                fasilitas_kode: { required: true, maxlength: 20 },
                fasilitas_nama: { required: true, maxlength: 100 },
                status: { required: true },
                tahun_pengadaan: { digits: true, min: 1900, max: {{ date('Y') }} }
            },
            errorElement: 'small',
            errorClass: 'error-text form-text text-danger',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            highlight: function(element) {
                jQuery(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                jQuery(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                console.log('Form is valid, submitting...');
                var formData = new FormData(form);
                console.log('Request URL:', form.action); // Log the exact URL
                jQuery.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        jQuery('#btn-simpan').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                    },
                    success: function(response) {
                        jQuery('#btn-simpan').prop('disabled', false).html('Simpan');
                        console.log('Server response:', response);
                        if (response.status) {
                            var modal = bootstrap.Modal.getInstance(document.getElementById('myModal'));
                            if (modal) {
                                modal.hide();
                            } else {
                                jQuery('.modal').modal('hide');
                            }
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Data berhasil ditambahkan',
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
                        jQuery('#btn-simpan').prop('disabled', false).html('Simpan');
                        console.error('AJAX error:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText
                        });
                        jQuery('.error-text').text('');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            jQuery.each(xhr.responseJSON.errors, function(prefix, val) {
                                jQuery('#error-' + prefix).text(val[0]);
                            });
                        }
                        Swal.fire('Error', 'Terjadi kesalahan: ' + (xhr.responseJSON?.message || 'Route not found'), 'error');
                    }
                });
            }
        });
    }
});
</script>