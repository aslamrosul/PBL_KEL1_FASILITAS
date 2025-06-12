@empty($klasifikasi)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data klasifikasi tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ secure_url('/klasifikasi/' . $klasifikasi->klasifikasi_id . '/delete_ajax') }}" method="POST" id="form-delete-klasifikasi">
        @csrf
        @method('DELETE')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Klasifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary">
                        Apakah Anda yakin ingin menghapus data klasifikasi berikut?
                    </div>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Kode Klasifikasi:</th>
                            <td>{{ $klasifikasi->klasifikasi_kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama Klasifikasi:</th>
                            <td>{{ $klasifikasi->klasifikasi_nama }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function () {
            $("#form-delete-klasifikasi").on('submit', function (e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status) {
                            $('.modal').modal('hide');
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            dataKlasifikasi.ajax.reload(null, false); // pastikan variabel ini sesuai dengan nama datatable kamu
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        $('.error-text').text('');
                        $.each(errors, function (prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                    }
                });
            });
        });
    </script>
@endempty
