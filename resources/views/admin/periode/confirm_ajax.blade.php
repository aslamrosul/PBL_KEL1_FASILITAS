@empty($periode)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data periode tidak ditemukan.</div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/periode/' . $periode->periode_id . '/delete_ajax') }}" method="POST" id="form-delete-periode">
        @csrf
        @method('DELETE')
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary">
                        Apakah Anda yakin ingin menghapus data periode berikut?
                    </div>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Kode Periode:</th>
                            <td>{{ $periode->periode_kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama Periode:</th>
                            <td>{{ $periode->periode_nama }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai:</th>
                            <td>{{ $periode->tanggal_mulai }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai:</th>
                            <td>{{ $periode->tanggal_selesai }}</td>
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
            $("#form-delete-periode").on('submit', function (e) {
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
                            dataPeriode.ajax.reload(null, false);
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