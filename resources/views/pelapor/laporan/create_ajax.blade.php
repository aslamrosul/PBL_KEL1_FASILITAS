<div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formLaporan" action="{{ url('/pelapor/laporan/store_ajax') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Laporan</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="gedung" class="form-label">Gedung</label>
                        <select class="form-control" id="gedung" name="gedung" required>
                            <option value="">Pilih Gedung</option>
                            @foreach ($gedung as $item)
                                <option value="{{ $item->gedung_id }}">{{ $item->gedung_nama }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="lantai" class="form-label">Lantai</label>
                        <select class="form-control" id="lantai" name="lantai" required disabled>
                            <option value="">Pilih Lantai</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="ruang" class="form-label">Ruang</label>
                        <select class="form-control" id="ruang" name="ruang" required disabled>
                            <option value="">Pilih Ruang</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="barang" class="form-label">Barang</label>
                        <select class="form-control" id="barang" name="barang" required disabled>
                            <option value="">Pilih Barang</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="fasilitas_id" class="form-label">Fasilitas</label>
                        <select class="form-control" id="fasilitas_id" name="fasilitas_id" required disabled>
                            <option value="">Pilih Fasilitas</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="periode_id" class="form-label">Periode</label>
                        <select class="form-control" id="periode_id" name="periode_id" required>
                            <option value="">Pilih Periode</option>
                            @foreach ($periode as $item)
                                <option value="{{ $item->periode_id }}">{{ $item->periode_nama }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto (Opsional)</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        // Reset dropdowns saat modal dibuka
        jQuery('#myModal').on('show.bs.modal', function() {
            jQuery('#lantai, #ruang, #barang, #fasilitas_id').prop('disabled', true).html('<option value="">Pilih</option>');
        });

        // Event untuk gedung
        jQuery('#gedung').on('change', function() {
            let gedung_id = jQuery(this).val();
            console.log('Gedung dipilih:', gedung_id); // Debug
            jQuery('#lantai, #ruang, #barang, #fasilitas_id').prop('disabled', true).html('<option value="">Pilih</option>');
            
            if (gedung_id) {
                jQuery.ajax({
                    url: '{{ url("/pelapor/lantai") }}/' + gedung_id,
                    type: 'GET',
                    success: function(response) {
                        console.log('Data lantai:', response); // Debug
                        let options = '<option value="">Pilih Lantai</option>';
                        jQuery.each(response.lantai, function(index, item) {
                            options += `<option value="${item.lantai_id}">${item.lantai_nomor}</option>`;
                        });
                        jQuery('#lantai').html(options).prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr); // Debug
                        alert('Gagal mengambil data lantai.');
                    }
                });
            }
        });

        // Event untuk lantai
        jQuery('#lantai').on('change', function() {
            let lantai_id = jQuery(this).val();
            jQuery('#ruang, #barang, #fasilitas_id').prop('disabled', true).html('<option value="">Pilih</option>');
            
            if (lantai_id) {
                jQuery.ajax({
                    url: '{{ url("/pelapor/ruang") }}/' + lantai_id,
                    type: 'GET',
                    success: function(response) {
                        let options = '<option value="">Pilih Ruang</option>';
                        jQuery.each(response.ruang, function(index, item) {
                            options += `<option value="${item.ruang_id}">${item.ruang_nama}</option>`;
                        });
                        jQuery('#ruang').html(options).prop('disabled', false);
                    },
                    error: function() {
                        alert('Gagal mengambil data ruang.');
                    }
                });
            }
        });

        // Event untuk ruang
        jQuery('#ruang').on('change', function() {
            let ruang_id = jQuery(this).val();
            jQuery('#barang, #fasilitas_id').prop('disabled', true).html('<option value="">Pilih</option>');
            
            if (ruang_id) {
                jQuery.ajax({
                    url: '{{ url("/pelapor/barang") }}/' + ruang_id,
                    type: 'GET',
                    success: function(response) {
                        let options = '<option value="">Pilih Barang</option>';
                        jQuery.each(response.barang, function(index, item) {
                            options += `<option value="${item.barang_id}">${item.barang_nama}</option>`;
                        });
                        jQuery('#barang').html(options).prop('disabled', false);
                    },
                    error: function() {
                        alert('Gagal mengambil data barang.');
                    }
                });
            }
        });

        // Event untuk barang
        jQuery('#barang').on('change', function() {
            let barang_id = jQuery(this).val();
            jQuery('#fasilitas_id').prop('disabled', true).html('<option value="">Pilih Fasilitas</option>');
            
            if (barang_id) {
                jQuery.ajax({
                    url: '{{ url("/pelapor/fasilitas") }}/' + barang_id,
                    type: 'GET',
                    success: function(response) {
                        let options = '<option value="">Pilih Fasilitas</option>';
                        jQuery.each(response.fasilitas, function(index, item) {
                            options += `<option value="${item.fasilitas_id}">${item.fasilitas_nama}</option>`;
                        });
                        jQuery('#fasilitas_id').html(options).prop('disabled', false);
                    },
                    error: function() {
                        alert('Gagal mengambil data fasilitas.');
                    }
                });
            }
        });

        // Submit form
        jQuery('#formLaporan').on('submit', function(e) {
            e.preventDefault();
            jQuery('.invalid-feedback').empty();
            jQuery('.form-control').removeClass('is-invalid');
            jQuery.ajax({
                url: jQuery(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        jQuery('#myModal').modal('hide');
                        window.dataLaporan.ajax.reload();
                        alert(response.message);
                    } else {
                        jQuery.each(response.msgField, function(field, messages) {
                            jQuery('#' + field).addClass('is-invalid');
                            jQuery('#' + field).siblings('.invalid-feedback').text(messages[0]);
                        });
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>