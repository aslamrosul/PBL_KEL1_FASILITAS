@extends('layouts.template')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Feedback</h3>
                    <p class="text-subtitle text-muted">Detail umpan balik untuk laporan Anda</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Rating</h5>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i
                                    class="bi bi-star-fill {{ $i <= $laporan->feedback->rating ? 'text-warning' : 'text-secondary' }}"></i>
                            @endfor
                            <span class="ms-2">{{ $laporan->feedback->rating }}/5</span>
                        </div>
                    </div>

                    @if($laporan->feedback->komentar)
                        <div class="mb-4">
                            <h5>Komentar</h5>
                            <p class="text-muted">{{ $laporan->feedback->komentar }}</p>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('pelapor.riwayat.index') }}"
                                class="btn btn-primary">Kembali ke Riwayat</a>
                        </div>
                        <div>
                            <a href="{{ route('pelapor.feedback.edit', $laporan->laporan_id) }}"
                                class="btn btn-warning me-2">Edit</a>
                            <a href="{{ route('pelapor.feedback.confirm', $laporan->laporan_id) }}"
                                class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection