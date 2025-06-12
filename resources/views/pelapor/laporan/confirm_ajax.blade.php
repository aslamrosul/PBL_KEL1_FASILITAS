<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Hapus Laporan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formDeleteLaporan" action="{{ secure_url('/pelapor/laporan/' . $laporan->laporan_id . '/delete_ajax') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus laporan <strong>{{ $laporan->judul }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    jQuery('#formDeleteLaporan').on('submit', function(e) {
        e.preventDefault();
        jQuery.ajax({
            url: jQuery(this).attr('action'),
            type: 'POST',
            data: jQuery(this).serialize(),
            success: function(response) {
                if (response.status) {
                    jQuery('#myModal').modal('hide');
                    window.dataLaporan.ajax.reload();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
            }
        });
    });
</script>