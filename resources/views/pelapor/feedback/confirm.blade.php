@extends('layouts.template')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Hapus Umpan Balik</h3>
                <p class="text-subtitle text-muted">Konfirmasi penghapusan umpan balik</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <h5>Apakah Anda yakin ingin menghapus umpan balik ini?</h5>
                    <p>Rating: {{ $laporan->feedback->rating }}/5</p>
                    @if($laporan->feedback->komentar)
                    <p>Komentar: {{ $laporan->feedback->komentar }}</p>
                    @endif
                </div>

                <form action="{{ route('pelapor.feedback.delete', $laporan->laporan_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('pelapor.feedback.show', $laporan->laporan_id) }}" class="btn btn-light-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection