
@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Manage Pairwise Comparisons</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('kriteria.updatePairwise') }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    @foreach ($kriteria as $k)
                        <th>{{ $k->kriteria_nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($kriteria as $k1)
                    <tr>
                        <td>{{ $k1->kriteria_nama }}</td>
                        @foreach ($kriteria as $k2)
                            <td>
                                @if ($k1->kriteria_id == $k2->kriteria_id)
                                    <input type="number" value="1" readonly class="form-control">
                                @elseif ($k1->kriteria_id < $k2->kriteria_id)
                                    <input type="number" name="pairwise[{{ $k1->kriteria_id }}][{{ $k2->kriteria_id }}]" 
                                           value="{{ $pairwise[$k1->kriteria_id . '-' . $k2->kriteria_id]->nilai ?? 1 }}"
                                           step="0.1" min="0.1" max="9" class="form-control">
                                @else
                                    <input type="number" value="{{ $pairwise[$k2->kriteria_id . '-' . $k1->kriteria_id]->nilai ? 1 / $pairwise[$k2->kriteria_id . '-' . $k1->kriteria_id]->nilai : 1 }}"
                                           readonly class="form-control">
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Update and Calculate Weights</button>
    </form>
</div>
@endsection
