@empty($laporan)
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data laporan tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pelapor/laporan/' . $laporan->laporan_id . '/update_ajax') }}" method="POST" id="form-edit-laporan" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Laporan</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $laporan->judul }}" required>
                        <small id="error-judul" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $laporan->deskripsi }}</textarea>
                        <small id="error-deskripsi" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="periode_id" class="form-label">Periode</label>
                        <select class="form-control" id="periode_id" name="periode_id" required>
                            <option value="">Pilih Periode</option>
                            @foreach ($periode as $item)
                                <option value="{{ $item->periode_id }}" {{ $item->periode_id == $laporan->periode_id ? 'selected' : '' }}>
                                    {{ $item->periode_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-periode_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="fasilitas_id" class="form-label">Fasilitas</label>
                        <select class="form-control" id="fasilitas_id" name="fasilitas_id" required>
                            <option value="">Pilih Fasilitas</option>
                            @foreach ($fasilitas as $item)
                                <option value="{{ $item->fasilitas_id }}" {{ $item->fasilitas_id == $laporan->fasilitas_id ? 'selected' : '' }}>
                                    {{ $item->fasilitas_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-fasilitas_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="gedung_id" class="form-label">Gedung</label>
                        <select class="form-control" id="gedung_id" name="gedung_id" required>
                            <option value="">Pilih Gedung</option>
                            @foreach ($gedung as $item)
                                <option value="{{ $item->gedung_id }}" {{ $item->gedung_id == $laporan->gedung_id ? 'selected' : '' }}>
                                    {{ $item->gedung_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-gedung_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="lantai_id" class="form-label">Lantai</label>
                        <select class="form-control" id="lantai_id" name="lantai_id" required>
                            <option value="">Pilih Lantai</option>
                            @foreach ($lantai as $item)
                                <option value="{{ $item->lantai_id }}" {{ $item->lantai_id == $laporan->lantai_id ? 'selected' : '' }}>
                                    {{ $item->lantai_nomor }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-lantai_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="ruang_id" class="form-label">Ruang</label>
                        <select class="form-control" id="ruang_id" name="ruang_id" required>
                            <option value="">Pilih Ruang</option>
                            @foreach ($ruang as $item)
                                <option value="{{ $item->ruang_id }}" {{ $item->ruang_id == $laporan->ruang_id ? 'selected' : '' }}>
                                    {{ $item->ruang_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-ruang_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Barang</label>
                        <select class="form-control" id="barang_id" name="barang_id" required>
                            <option value="">Pilih Barang</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->barang_id }}" {{ $item->barang_id == $laporan->barang_id ? 'selected' : '' }}>
                                    {{ $item->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-barang_id" class="text-danger error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto (Opsional)</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        @if ($laporan->foto_path)
                            <small class="form-text text-muted">File saat ini: {{ basename($laporan->foto_path) }}</small>
                        @endif
                        <small id="error-foto" class="text-danger error-text"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#form-edit-laporan').on('submit', function(e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);
                $('.error-text').text('');
                $.ajax({
                    url: form.action,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('.modal').modal('hide');
                            window.dataLaporan.ajax.reload(null, false);
                            Swal.fire('Berhasil', response.message, 'success');
                        } else {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors || xhr.responseJSON.msgField;
                        $.each(errors, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire('Gagal', xhr.responseJSON.message || 'Terjadi kesalahan', 'error');
                    }
                });
            });

            // Cascading dropdowns
            $('#gedung_id').on('change', function() {
                var gedung_id = $(this).val();
                $('#lantai_id').prop('disabled', true).html('<option value="">Pilih Lantai</option>');
                $('#ruang_id').prop('disabled', true).html('<option value="">Pilih Ruang</option>');
                $('#barang_id').prop('disabled', true).html('<option value="">Pilih Barang</option>');
                if (gedung_id) {
                    $.ajax({
                        url: '{{ url("/pelapor/laporan/getLantai") }}',
                        type: 'GET',
                        data: { gedung_id: gedung_id },
                        success: function(data) {
                            $('#lantai_id').prop('disabled', false);
                            $.each(data, function(index, item) {
                                $('#lantai_id').append('<option value="' + item.lantai_id + '">' + item.lantai_nomor + '</option>');
                            });
                            // Pre-select current lantai_id if available
                            if ('{{ $laporan->lantai_id }}') {
                                $('#lantai_id').val('{{ $laporan->lantai_id }}').trigger('change');
                            }
                        }
                    });
                }
            });

            $('#lantai_id').on('change', function() {
                var lantai_id = $(this).val();
                $('#ruang_id').prop('disabled', true).html('<option value="">Pilih Ruang</option>');
                $('#barang_id').prop('disabled', true).html('<option value="">Pilih Barang</option>');
                if (lantai_id) {
                    $.ajax({
                        url: '{{ url("/pelapor/laporan/getRuang") }}',
                        type: 'GET',
                        data: { lantai_id: lantai_id },
                        success: function(data) {
                            $('#ruang_id').prop('disabled', false);
                            $.each(data, function(index, item) {
                                $('#ruang_id').append('<option value="' + item.ruang_id + '">' + item.ruang_nama + '</option>');
                            });
                            // Pre-select current ruang_id if available
                            if ('{{ $laporan->ruang_id }}') {
                                $('#ruang_id').val('{{ $laporan->ruang_id }}').trigger('change');
                            }
                        }
                    });
                }
            });

            $('#ruang_id').on('change', function() {
                var ruang_id = $(this).val();
                $('#barang_id').prop('disabled', true).html('<option value="">Pilih Barang</option>');
                if (ruang_id) {
                    $.ajax({
                        url: '{{ url("/pelapor/laporan/getBarang") }}',
                        type: 'GET',
                        data: { ruang_id: ruang_id },
                        success: function(data) {
                            $('#barang_id').prop('disabled', false);
                            $.each(data, function(index, item) {
                                $('#barang_id').append('<option value="' + item.barang_id + '">' + item.barang_nama + '</option>');
                            });
                            // Pre-select current barang_id if available
                            if ('{{ $laporan->barang_id }}') {
                                $('#barang_id').val('{{ $laporan->barang_id }}');
                            }
                        }
                    });
                }
            });

            // Trigger change on gedung_id to load initial lantai, ruang, and barang
            if ('{{ $laporan->gedung_id }}') {
                $('#gedung_id').val('{{ $laporan->gedung_id }}').trigger('change');
            }
        });
    </script>
@endempty