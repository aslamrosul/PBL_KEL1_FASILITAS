@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="table_laporan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Pelapor</th>
                            <th>Fasilitas</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    {{-- Modal untuk menampilkan detail, tambah, atau edit laporan --}}
    <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
    </div>
@endsection

@push('css')
    {{-- Tambahkan CSS khusus jika diperlukan --}}
@endpush

@push('js')
    <script>
        // Konfigurasi AJAX untuk menyertakan CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * Fungsi untuk memuat konten ke dalam modal menggunakan AJAX.
         * @param {string} url - URL yang akan dimuat ke dalam modal.
         */
        function modalAction(url = '') {
            $.ajax({
                url: url,
                type: 'GET', // Menggunakan GET untuk memuat form atau detail
                success: function(response) {
                    $('#myModal').html(response); // Memuat respons ke dalam modal
                    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                        keyboard: false, // Nonaktifkan penutupan modal dengan keyboard
                        backdrop: 'static' // Modal tidak akan tertutup saat mengklik di luar area modal
                    });
                    myModal.show(); // Menampilkan modal
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);
                    // Menampilkan pesan error yang lebih user-friendly
                    alert('Gagal memuat data: ' + (xhr.responseJSON ? xhr.responseJSON.message : xhr.status + ' ' + xhr.statusText));
                }
            });
        }

        var dataLaporan; // Variabel global untuk instance DataTables
        $(document).ready(function() {
            // Inisialisasi DataTables untuk tabel laporan
            window.dataLaporan = $('#table_laporan').DataTable({
                serverSide: true, // Mengaktifkan mode server-side processing
                ajax: {
                    // URL untuk mengambil data laporan dari controller
                    url: "{{ url('laporan-admin/list') }}",
                    type: "POST" // Menggunakan metode POST sesuai konfigurasi DataTables server-side
                },
                columns: [
                    // Definisi kolom-kolom tabel
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false }, // Nomor urut
                    { data: "judul", className: "", orderable: true, searchable: true },
                    { data: "user_nama", className: "", orderable: true, searchable: true }, // Nama pelapor dari relasi
                    { data: "fasilitas", className: "", orderable: true, searchable: true }, // Nama fasilitas dari relasi
                    { data: "periode", className: "", orderable: true, searchable: true }, // Nama periode dari relasi
                     {
                        data: "status", render: function (data) {
                            return renderStatusBadge(data);
                        },
                        className: "", orderable: true, searchable: true
                    },
                    { data: "tanggal_selesai", className: "", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", orderable: false, searchable: false } // Kolom aksi (tombol)
                ]
            });
        });
    </script>
@endpush