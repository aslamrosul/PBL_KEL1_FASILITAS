@extends('layouts.template')

@section('content')

    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header border-bottom-0 d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Form Edit Laporan</h4>
            <div class="card-tools">
                <a href="{{ secure_url('/pelapor/laporan') }}" class="btn btn-sm btn-outline-secondary"><i
                        class="bi bi-arrow-left me-2"></i>Kembali</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form id="formEditLaporan" action="{{ secure_url('/pelapor/laporan/'.  $laporan->laporan_id.'/update/') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Penting: Gunakan method PUT untuk update --}}

                <div class="card shadow-sm mb-4 border-primary">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary mb-4"><i class="bi bi-building me-2"></i>Pilih Lokasi &
                            Barang Bermasalah</h5>
                        <div class="row g-3">
                            <div class="col-md-4 col-sm-6">
                                <label for="gedung_id" class="form-label">Gedung</label>
                                <select class="form-select form-select-sm @error('gedung_id') is-invalid @enderror"
                                    id="gedung_id" name="gedung_id" required>
                                    <option value="">Pilih Gedung</option>
                                    @foreach ($gedungs as $gedung)
                                        <option value="{{ $gedung->gedung_id }}" {{ (old('gedung_id', $laporan->gedung_id) == $gedung->gedung_id) ? 'selected' : '' }}>
                                            {{ $gedung->gedung_nama }}</option>
                                    @endforeach
                                </select>
                                @error('gedung_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <label for="lantai_id" class="form-label">Lantai</label>
                                <select class="form-select form-select-sm @error('lantai_id') is-invalid @enderror"
                                    id="lantai_id" name="lantai_id" required>
                                    <option value="">Pilih Lantai</option>
                                    {{-- Lantai akan diisi via AJAX atau langsung jika old value ada --}}
                                </select>
                                @error('lantai_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <label for="ruang_id" class="form-label">Ruang</label>
                                <select class="form-select form-select-sm @error('ruang_id') is-invalid @enderror"
                                    id="ruang_id" name="ruang_id" required>
                                    <option value="">Pilih Ruang</option>
                                    {{-- Ruang akan diisi via AJAX atau langsung jika old value ada --}}
                                </select>
                                @error('ruang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label for="barang_id" class="form-label">Barang</label>
                                <select class="form-select form-select-sm @error('barang_id') is-invalid @enderror"
                                    id="barang_id" name="barang_id" required>
                                    <option value="">Pilih Barang</option>
                                    {{-- Barang akan diisi via AJAX atau langsung jika old value ada --}}
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label for="fasilitas_id" class="form-label">Fasilitas</label>
                                <select class="form-select form-select-sm @error('fasilitas_id') is-invalid @enderror"
                                    id="fasilitas_id" name="fasilitas_id" required>
                                    <option value="">Pilih Fasilitas</option>
                                    {{-- Fasilitas akan diisi via AJAX atau langsung jika old value ada --}}
                                </select>
                                @error('fasilitas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark mb-3"><i class="bi bi-pencil-square me-2"></i>Detail
                                    Laporan</h5>
                                <div class="mb-3">
                                    <label for="judul" class="form-label fw-bold">Judul Laporan</label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('judul') is-invalid @enderror" id="judul"
                                        name="judul" value="{{ old('judul', $laporan->judul) }}"
                                        placeholder="Contoh: AC Rusak di Ruang Server" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="deskripsi" class="form-label fw-bold">Deskripsi Laporan</label>
                                    <textarea class="form-control form-control-sm @error('deskripsi') is-invalid @enderror"
                                        id="deskripsi" name="deskripsi" rows="8"
                                        placeholder="Jelaskan detail masalah yang Anda temukan, seberapa parah, dan kapan terjadi."
                                        required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card shadow-sm mb-4 h-100">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark mb-3"><i class="bi bi-camera me-2"></i>Unggah Foto
                                    (Opsional)</h5>
                                <p class="text-muted small">Membantu memperjelas laporan Anda.</p>
                                <div class="mb-3">
                                    <label for="foto_path" class="form-label">Pilih Gambar Baru</label>
                                    <input type="file"
                                        class="form-control form-control-sm @error('foto_path') is-invalid @enderror"
                                        id="foto_path" name="foto_path" accept="image/*">
                                    @error('foto_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="foto_preview" class="text-center p-2 border rounded bg-light">
                                    @if ($laporan->foto_path)
                                        <img src="{{ secure_url('storage/' . $laporan->foto_path) }}" alt="Foto Laporan Sebelumnya"
                                            class="img-fluid rounded" style="max-height: 150px;">
                                        <p class="text-muted mb-0 small mt-2">Foto Laporan Sebelumnya</p>
                                    @else
                                        <p class="text-muted mb-0 small">Tidak ada foto terlampir.</p>
                                        <img src="#" alt="Pratinjau Foto" class="img-fluid rounded mt-2"
                                            style="max-height: 150px; display: none;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm"><i
                            class="bi bi-save-fill me-2"></i>Update Laporan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Fungsi untuk memuat dropdown bertingkat
            function loadLantai(gedungId, selectedLantaiId) {
                $('#lantai_id').prop('disabled', true).html('<option value="">Pilih Lantai</option>');
                if (gedungId) {
                    $.ajax({
                        url: '{{ url("/pelapor/laporan/get-lantai") }}/' + gedungId,
                        type: 'GET',
                        success: function (data) {
                            let options = '<option value="">Pilih Lantai</option>';
                            data.forEach(lantai => {
                                options += `<option value="${lantai.lantai_id}" ${lantai.lantai_id == selectedLantaiId ? 'selected' : ''}>${lantai.lantai_nomor}</option>`;
                            });
                            $('#lantai_id').html(options).prop('disabled', false);
                        },
                        error: function () {
                            Swal.fire('Error', 'Gagal memuat data lantai', 'error');
                        }
                    });
                }
            }

            function loadRuang(lantaiId, selectedRuangId) {
                $('#ruang_id').prop('disabled', true).html('<option value="">Pilih Ruang</option>');
                if (lantaiId) {
                    $.ajax({
                        url: '{{ url("/pelapor/laporan/get-ruang") }}/' + lantaiId,
                        type: 'GET',
                        success: function (data) {
                            let options = '<option value="">Pilih Ruang</option>';
                            data.forEach(ruang => {
                                options += `<option value="${ruang.ruang_id}" ${ruang.ruang_id == selectedRuangId ? 'selected' : ''}>${ruang.ruang_nama}</option>`;
                            });
                            $('#ruang_id').html(options).prop('disabled', false);
                        },
                        error: function () {
                            Swal.fire('Error', 'Gagal memuat data ruang', 'error');
                        }
                    });
                }
            }

            function loadBarang(ruangId, selectedBarangId) {
                $('#barang_id').prop('disabled', true).html('<option value="">Pilih Barang</option>');
                if (ruangId) {
                    $.ajax({
                        url: '{{ url("/pelapor/laporan/get-barang") }}/' + ruangId,
                        type: 'GET',
                        success: function (data) {
                            let options = '<option value="">Pilih Barang</option>';
                            data.forEach(barang => {
                                options += `<option value="${barang.barang_id}" ${barang.barang_id == selectedBarangId ? 'selected' : ''}>${barang.barang_nama}</option>`;
                            });
                            $('#barang_id').html(options).prop('disabled', false);
                        },
                        error: function () {
                            Swal.fire('Error', 'Gagal memuat data barang', 'error');
                        }
                    });
                }
            }

            function loadFasilitas(barangId, selectedFasilitasId) {
                $('#fasilitas_id').prop('disabled', true).html('<option value="">Pilih Fasilitas</option>');
                if (barangId) {
                    $.ajax({
                        url: '{{ url("/pelapor/laporan/get-fasilitas") }}/' + barangId,
                        type: 'GET',
                        success: function (data) {
                            let options = '<option value="">Pilih Fasilitas</option>';
                            data.forEach(fasilitas => {
                                options += `<option value="${fasilitas.fasilitas_id}" ${fasilitas.fasilitas_id == selectedFasilitasId ? 'selected' : ''}>${fasilitas.fasilitas_nama}</option>`;
                            });
                            $('#fasilitas_id').html(options).prop('disabled', false);
                        },
                        error: function () {
                            Swal.fire('Error', 'Gagal memuat data fasilitas', 'error');
                        }
                    });
                }
            }

            // Ketika halaman dimuat, isi dropdown berdasarkan data laporan yang sudah ada
            const initialGedungId = '{{ old('gedung_id', $laporan->gedung_id) }}';
            const initialLantaiId = '{{ old('lantai_id', $laporan->lantai_id) }}';
            const initialRuangId = '{{ old('ruang_id', $laporan->ruang_id) }}';
            const initialBarangId = '{{ old('barang_id', $laporan->barang_id) }}';
            const initialFasilitasId = '{{ old('fasilitas_id', $laporan->fasilitas_id) }}';

            if (initialGedungId) {
                loadLantai(initialGedungId, initialLantaiId);
            }
            if (initialLantaiId) {
                loadRuang(initialLantaiId, initialRuangId);
            }
            if (initialRuangId) {
                loadBarang(initialRuangId, initialBarangId);
            }
            if (initialBarangId) {
                loadFasilitas(initialBarangId, initialFasilitasId);
            }

            // Event listener untuk perubahan dropdown
            $('#gedung_id').on('change', function () {
                loadLantai($(this).val(), null);
                $('#ruang_id').prop('disabled', true).html('<option value="">Pilih Ruang</option>');
                $('#barang_id').prop('disabled', true).html('<option value="">Pilih Barang</option>');
                $('#fasilitas_id').prop('disabled', true).html('<option value="">Pilih Fasilitas</option>');
            });

            $('#lantai_id').on('change', function () {
                loadRuang($(this).val(), null);
                $('#barang_id').prop('disabled', true).html('<option value="">Pilih Barang</option>');
                $('#fasilitas_id').prop('disabled', true).html('<option value="">Pilih Fasilitas</option>');
            });

            $('#ruang_id').on('change', function () {
                loadBarang($(this).val(), null);
                $('#fasilitas_id').prop('disabled', true).html('<option value="">Pilih Fasilitas</option>');
            });

            $('#barang_id').on('change', function () {
                loadFasilitas($(this).val(), null);
            });

            // Image Preview
            $('#foto_path').on('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#foto_preview img').attr('src', e.target.result).show();
                        $('#foto_preview p').text('Pratinjau Gambar Baru').show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika input file dikosongkan, kembalikan ke foto lama atau teks default
                    @if ($laporan->foto_path)
                        $('#foto_preview img').attr('src', '{{ secure_url('storage/' . $laporan->foto_path) }}').show();
                        $('#foto_preview p').text('Foto Laporan Sebelumnya').show();
                    @else
                        $('#foto_preview img').hide().attr('src', '');
                        $('#foto_preview p').text('Tidak ada foto terlampir.').show();
                    @endif
                }
            });

            // Form Validation
            $('#formEditLaporan').validate({
                rules: {
                    judul: { required: true, minlength: 3 },
                    deskripsi: { required: true, minlength: 10 },
                    gedung_id: { required: true },
                    lantai_id: { required: true },
                    ruang_id: { required: true },
                    barang_id: { required: true },
                    fasilitas_id: { required: true },
                    foto_path: { accept: "image/*" }
                },
                messages: {
                    judul: { required: "Judul laporan wajib diisi", minlength: "Judul minimal 3 karakter" },
                    deskripsi: { required: "Deskripsi laporan wajib diisi", minlength: "Deskripsi minimal 10 karakter" },
                    gedung_id: { required: "Pilih gedung terlebih dahulu" },
                    lantai_id: { required: "Pilih lantai terlebih dahulu" },
                    ruang_id: { required: "Pilih ruang terlebih dahulu" },
                    barang_id: { required: "Pilih barang terlebih dahulu" },
                    fasilitas_id: { required: "Pilih fasilitas terlebih dahulu" },
                    foto_path: { accept: "File harus berupa gambar (jpg, png, dll)" }
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function (error, element) {
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('span.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
@endpush