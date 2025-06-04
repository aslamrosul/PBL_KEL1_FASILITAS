<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Ubah Status Laporan #{{ $laporan->laporan_id }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {{-- Form untuk memperbarui status laporan --}}
        <form id="form-update_status" action="{{ route('laporan.update_status', $laporan->laporan_id) }}" method="POST">
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

                <hr> {{-- Garis pemisah --}}

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
    // Event listener untuk tombol "Status" di tabel DataTables
    $('#table-laporan').on('click', '.update-status-btn', function() {
        var laporanId = $(this).data('id');
        var currentStatus = $(this).data('current-status');

        // Tampilkan modal atau SweetAlert2 untuk memilih status baru
        Swal.fire({
            title: 'Ubah Status Laporan',
            html: `
                <div class="form-group text-left">
                    <label for="new_status">Status Baru:</label>
                    <select id="new_status" class="form-control swal2-input">
                        <option value="Menunggu" ${currentStatus === 'Menunggu' ? 'selected' : ''}>Menunggu</option>
                        <option value="Diterima" ${currentStatus === 'Diterima' ? 'selected' : ''}>Diterima</option>
                        <option value="Ditolak" ${currentStatus === 'Ditolak' ? 'selected' : ''}>Ditolak</option>
                        <option value="Diproses" ${currentStatus === 'Diproses' ? 'selected' : ''}>Diproses</option>
                        <option value="Selesai" ${currentStatus === 'Selesai' ? 'selected' : ''}>Selesai</option>
                    </select>
                </div>
                <div class="form-group text-left" id="alasan_penolakan_group" style="display: none;">
                    <label for="alasan_penolakan">Alasan Penolakan (jika Ditolak):</label>
                    <textarea id="alasan_penolakan" class="form-control swal2-textarea" placeholder="Masukkan alasan penolakan"></textarea>
                </div>
                <div class="form-group text-left">
                    <label for="keterangan_histori">Keterangan Histori (Opsional):</label>
                    <textarea id="keterangan_histori" class="form-control swal2-textarea" placeholder="Tambahkan catatan untuk histori laporan"></textarea>
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            didOpen: () => {
                const newStatusSelect = Swal.getPopup().querySelector('#new_status');
                const alasanPenolakanGroup = Swal.getPopup().querySelector('#alasan_penolakan_group');

                // Tampilkan/sembunyikan field alasan penolakan
                const toggleAlasanPenolakan = () => {
                    if (newStatusSelect.value === 'Ditolak') {
                        alasanPenolakanGroup.style.display = 'block';
                    } else {
                        alasanPenolakanGroup.style.display = 'none';
                    }
                };

                newStatusSelect.addEventListener('change', toggleAlasanPenolakan);
                toggleAlasanPenolakan(); // Panggil saat modal terbuka untuk inisialisasi
            },
            preConfirm: () => {
                const newStatus = Swal.getPopup().querySelector('#new_status').value;
                const alasanPenolakan = Swal.getPopup().querySelector('#alasan_penolakan').value;
                const keteranganHistori = Swal.getPopup().querySelector('#keterangan_histori').value;

                if (newStatus === 'Ditolak' && !alasanPenolakan.trim()) {
                    Swal.showValidationMessage('Alasan penolakan wajib diisi jika status Ditolak.');
                    return false;
                }

                return { newStatus: newStatus, alasanPenolakan: alasanPenolakan, keteranganHistori: keteranganHistori };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { newStatus, alasanPenolakan, keteranganHistori } = result.value;

                // Kirim permintaan AJAX
                $.ajax({
                    url: '/laporan-admin/' + laporanId + '/update_status', // Pastikan route ini sesuai
                    type: 'PUT', // Menggunakan method PUT
                    data: {
                        _token: '{{ csrf_token() }}', // Laravel CSRF token
                        status: newStatus,
                        keterangan: keteranganHistori,
                        alasan_penolakan: newStatus === 'Ditolak' ? alasanPenolakan : null
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Reload DataTables setelah berhasil
                                if (window.tableLaporan) { // Sesuaikan dengan nama variabel DataTables Anda
                                    window.tableLaporan.ajax.reload();
                                } else if ($.fn.DataTable.isDataTable('#table-laporan')) {
                                    $('#table-laporan').DataTable().ajax.reload();
                                }
                            });
                        } else {
                            let errorMessage = response.message || 'Terjadi kesalahan yang tidak diketahui.';
                            if (response.errors) {
                                // Jika ada error validasi dari server
                                $.each(response.errors, function(key, value) {
                                    errorMessage += '\n- ' + value[0];
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: errorMessage,
                                showConfirmButton: true,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr);
                        let errorMsg = 'Terjadi kesalahan pada server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (error) {
                            errorMsg = error;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memperbarui status: ' + errorMsg,
                            showConfirmButton: true,
                        });

                        // Tampilkan error validasi dari server jika ada (misalnya status 422)
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Anda mungkin perlu menampilkan error ini di modal SweetAlert2 atau di form jika modalnya kompleks
                            // Untuk saat ini, akan ditampilkan di pesan text SweetAlert2
                            let validationErrors = '';
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                validationErrors += '\n- ' + value[0];
                            });
                            Swal.update({
                                text: Swal.getPopup().querySelector('.swal2-html-container').innerText + validationErrors
                            });
                        }
                    }
                });
            }
        });
    });
});
