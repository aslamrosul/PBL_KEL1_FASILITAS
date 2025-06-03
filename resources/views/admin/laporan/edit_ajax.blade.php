<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Ubah Status Laporan #{{ $laporan->laporan_id }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {{-- Form untuk memperbarui status laporan --}}
        <form id="form-update-status" action="{{ route('admin.laporan.update_status', $laporan->laporan_id) }}" method="POST">
            @csrf {{-- Token CSRF untuk keamanan --}}
            @method('PUT') {{-- Menggunakan metode PUT untuk operasi update --}}

            <div class="modal-body">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Laporan</label>
                    <input type="text" class="form-control" id="judul" value="{{ $laporan->judul }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="pelapor" class="form-label">Pelapor</label>
                    {{-- PENTING: Pastikan 'username' adalah nama kolom yang benar di UserModel Anda. Jika tidak, gunakan 'nama' atau kolom yang sesuai. --}}
                    <input type="text" class="form-control" id="pelapor" value="{{ $laporan->user->username ?? '-' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="fasilitas_nama" class="form-label">Fasilitas</label>
                    <input type="text" class="form-control" id="fasilitas_nama" value="{{ $laporan->fasilitas->fasilitas_nama ?? '-' }}" readonly>
                </div>

                <hr>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Baru</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Menunggu" {{ $laporan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diterima" {{ $laporan->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="Diproses" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Ditolak" {{ $laporan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    {{-- Area untuk menampilkan pesan error validasi --}}
                    <div class="invalid-feedback" id="status-error"></div>
                </div>

                {{-- Blok ini dikontrol oleh JavaScript, pastikan tidak ada @if/else/endif yang tidak seimbang di sini --}}
                <div class="mb-3" id="alasan_penolakan_div" style="display: {{ $laporan->status == 'Ditolak' ? 'block' : 'none' }};">
                    <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                    <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="3" placeholder="Masukkan alasan penolakan">{{ $laporan->alasan_penolakan }}</textarea>
                    {{-- Area untuk menampilkan pesan error validasi --}}
                    <div class="invalid-feedback" id="alasan_penolakan-error"></div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Catatan Histori (Opsional)</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan catatan untuk histori status"></textarea>
                    {{-- Area untuk menampilkan pesan error validasi --}}
                    <div class="invalid-feedback" id="keterangan-error"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fungsi untuk menampilkan/menyembunyikan field alasan penolakan
        function toggleAlasanPenolakan() {
            if ($('#status').val() === 'Ditolak') {
                $('#alasan_penolakan_div').show();
                $('#alasan_penolakan').prop('required', true); // Jadikan required jika status Ditolak
            } else {
                $('#alasan_penolakan_div').hide();
                $('#alasan_penolakan').prop('required', false); // Hapus required jika tidak Ditolak
                $('#alasan_penolakan').val(''); // Kosongkan nilai saat disembunyikan
            }
        }

        // Panggil saat halaman dimuat (untuk inisialisasi)
        toggleAlasanPenolakan();

        // Panggil saat status diubah
        $('#status').change(function() {
            toggleAlasanPenolakan();
        });

        // Handle form submission via AJAX
        $('#form-update-status').submit(function(e) {
            e.preventDefault(); // Mencegah form submit default

            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method'); // Akan menjadi "POST" karena @method('PUT')
            var formData = form.serialize();

            // Hapus pesan error sebelumnya
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').text('');

            $.ajax({
                url: url,
                type: 'POST', // Menggunakan POST karena @method('PUT') akan mengubahnya di sisi server
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#myModal').modal('hide'); // Tutup modal
                        window.dataLaporan.ajax.reload(); // Refresh DataTables
                    } else {
                        // Jika ada error validasi dari server
                        alert('Terjadi kesalahan: ' + response.message);
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '-error').text(value[0]);
                            });
                        }
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);
                    var errorMsg = 'Terjadi kesalahan pada server.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert('Gagal memperbarui status: ' + errorMsg);

                    // Tampilkan error validasi dari server jika ada
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '-error').text(value[0]);
                        });
                    }
                }
            });
        });
    });
</script>
