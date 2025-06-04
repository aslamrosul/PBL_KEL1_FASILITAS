@extends('layouts.template')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Beri Umpan Balik</h3>
                <p class="text-subtitle text-muted">Berikan penilaian Anda terhadap penanganan laporan</p>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pelapor.feedback.store', $laporan->laporan_id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <div class="rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                <label for="star{{ $i }}" title="{{ $i }} star">&#9733;</label>
                            @endfor
                        </div>
                        @error('rating')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar (Opsional)</label>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3" maxlength="500">{{ old('komentar') }}</textarea>
                        @error('komentar')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('pelapor.laporan.index') }}" class="btn btn-light-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Kirim Umpan Balik</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
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
        color: #ffc107;
        cursor: pointer;
    }
    .rating > label:hover,
    .rating > label:hover ~ label,
    .rating > input:checked ~ label {
        color: #ffc107;
    }
</style>
@endpush