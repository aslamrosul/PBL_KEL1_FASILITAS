@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h4 class="card-title">Detail Perhitungan AHP + TOPSIS</h4>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Informasi Laporan</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Judul</th>
                        <td>{{ $laporan->judul }}</td>
                    </tr>
                    <tr>
                        <th>Pelapor</th>
                        <td>{{ $laporan->user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Fasilitas</th>
                        <td>{{ $laporan->fasilitas->fasilitas_nama }}</td>
                    </tr>
                    <tr>
                        <th>Skor Akhir</th>
                        <td><strong>{{ number_format($laporan->rekomendasi->skor_total, 4) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Prioritas</th>
                        <td>
                            <span class="badge bg-{{ $laporan->bobotPrioritas->bobot_kode == 'URG' ? 'danger' : ($laporan->bobotPrioritas->bobot_kode == 'HIGH' ? 'warning' : 'primary') }}">
                                {{ $laporan->bobotPrioritas->bobot_nama }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Nilai Kriteria</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th>Nilai</th>
                            <th>Jenis</th>
                            <th>Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriteria as $k)
                        <tr>
                            <td>{{ $k->kriteria_nama }}</td>
                            <td>{{ $nilai_kriteria[strtolower($k->kriteria_kode)] ?? 0 }}</td>
                            <td>{{ $k->kriteria_jenis == 'benefit' ? 'Benefit' : 'Cost' }}</td>
                            <td>{{ $k->bobot }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Langkah 1: Matriks Keputusan</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Laporan</th>
                                    @foreach($kriteria as $k)
                                    <th>{{ $k->kriteria_kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriks_keputusan as $row)
                                <tr class="{{ $row['id'] == $laporan->laporan_id ? 'bg-light' : '' }}">
                                    <td>{{ $row['judul'] }}</td>
                                    @foreach($kriteria as $k)
                                    <td>{{ number_format($row[strtolower($k->kriteria_kode)], 4) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-secondary mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Langkah 2: Matriks Normalisasi</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Laporan</th>
                                    @foreach($kriteria as $k)
                                    <th>{{ $k->kriteria_kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriks_normalisasi as $i => $row)
                                <tr class="{{ $matriks_keputusan[$i]['id'] == $laporan->laporan_id ? 'bg-light' : '' }}">
                                    <td>{{ $matriks_keputusan[$i]['judul'] }}</td>
                                    @foreach($kriteria as $k)
                                    <td>{{ number_format($row[strtolower($k->kriteria_kode)], 4) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-secondary mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Langkah 3: Matriks Terbobot</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Laporan</th>
                                    @foreach($kriteria as $k)
                                    <th>{{ $k->kriteria_kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriks_terbobot as $i => $row)
                                <tr class="{{ $matriks_keputusan[$i]['id'] == $laporan->laporan_id ? 'bg-light' : '' }}">
                                    <td>{{ $matriks_keputusan[$i]['judul'] }}</td>
                                    @foreach($kriteria as $k)
                                    <td>{{ number_format($row[strtolower($k->kriteria_kode)], 4) }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-secondary mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Langkah 4: Solusi Ideal</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Solusi Ideal Positif (A+)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kriteria</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kriteria as $k)
                                        <tr>
                                            <td>{{ $k->kriteria_kode }}</td>
                                            <td>{{ number_format($solusi_ideal['positif'][strtolower($k->kriteria_kode)], 4) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Solusi Ideal Negatif (A-)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kriteria</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kriteria as $k)
                                        <tr>
                                            <td>{{ $k->kriteria_kode }}</td>
                                            <td>{{ number_format($solusi_ideal['negatif'][strtolower($k->kriteria_kode)], 4) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-success mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Langkah 5: Hasil Akhir Perankingan</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Laporan</th>
                                    <th>Jarak ke A+</th>
                                    <th>Jarak ke A-</th>
                                    <th>Skor Akhir</th>
                                    <th>Prioritas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil_akhir as $index => $row)
                                <tr class="{{ $row['laporan_id'] == $laporan->laporan_id ? 'bg-light' : '' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row['judul'] }}</td>
                                    <td>{{ number_format($row['jarak_positif'], 4) }}</td>
                                    <td>{{ number_format($row['jarak_negatif'], 4) }}</td>
                                    <td><strong>{{ number_format($row['skor_akhir'], 4) }}</strong></td>
                                    <td>
                                        @php
                                            $bobot = app('App\Models\BobotPrioritasModel')
                                                ->where('skor_min', '<=', $row['skor_akhir'])
                                                ->where('skor_max', '>=', $row['skor_akhir'])
                                                ->first();
                                        @endphp
                                        @if($bobot)
                                            <span class="badge bg-{{ $bobot->bobot_kode == 'URG' ? 'danger' : ($bobot->bobot_kode == 'HIGH' ? 'warning' : 'primary') }}">
                                                {{ $bobot->bobot_nama }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ url()->previous() }}" class="btn btn-default">Kembali</a>
    </div>
</div>
@endsection

@push('css')
<style>
    .bg-light {
        background-color: #f8f9fa!important;
        font-weight: bold;
    }
</style>
@endpush