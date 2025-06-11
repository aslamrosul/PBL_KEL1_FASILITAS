@extends('layouts.template')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Umpan Balik</h3>
                <p class="text-subtitle text-muted">Edit penilaian Anda terhadap penanganan laporan</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pelapor.feedback.update', $laporan->laporan_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <div class="rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $laporan->feedback->rating == $i ? 'checked' : '' }} required>
                                <label for="star{{ $i }}" title="{{ $i }} star"><i class="bi bi-star-fill"></i></label>
                            @endfor
                        </div>
                        @error('rating')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar (Opsional)</label>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3"
                            maxlength="500">{{ old('komentar', $laporan->feedback->komentar) }}</textarea>
                        @error('komentar')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('pelapor.feedback.show', $laporan->laporan_id) }}"
                            class="btn btn-light-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update Umpan Balik</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @endsection

@push('css')
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating > input {
        display: none;
    }
    .rating > label {
        position: relative;
        width: 1.5em;
        font-size: 2rem;
        cursor: pointer;
    }
    .rating > label i {
        color: #ccc !important; /* Warna abu-abu untuk bintang kosong */
        transition: color 0.2s ease; /* Efek transisi halus */
    }
    .rating > input:checked ~ label i,
    .rating > label:hover i,
    .rating > label:hover ~ label i {
        color: #ffc107 !important; /* Warna kuning saat dipilih atau hover */
    }
</style>
@endpush
