@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Dashboard Admin</h5>
                    <div class="card-tools">
                        @if($currentPeriod)
                            <span class="badge badge-primary">Periode Aktif: {{ $currentPeriod->periode_nama }}</span>
                        @else
                            <span class="badge badge-warning">Tidak ada periode aktif</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Report Statistics -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $reportStats['total'] }}</h3>
                                    <p>Total Laporan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <a href="{{ route('admin.laporan.index') }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $reportStats['pending'] }}</h3>
                                    <p>Pending</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <a href="{{ route('admin.laporan.index', ['status' => 'pending']) }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $reportStats['processed'] }}</h3>
                                    <p>Diproses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $reportStats['completed'] }}</h3>
                                    <p>Selesai</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Damage Trends Chart -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tren Kerusakan Fasilitas (6 Bulan Terakhir)</h3>
                </div>
                <div class="card-body">
                    <canvas id="damageTrendsChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- User Satisfaction -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kepuasan Pengguna</h3>
                </div>
                <div class="card-body text-center">
                    @if($satisfactionStats->total_feedback > 0)
                        <div class="rating-display mb-3">
                            <h1>{{ number_format($satisfactionStats->average_rating, 1) }}</h1>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($satisfactionStats->average_rating))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i - 0.5 <= $satisfactionStats->average_rating)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-muted">Dari {{ $satisfactionStats->total_feedback }} ulasan</p>
                        </div>
                    @else
                        <p class="text-muted">Belum ada data kepuasan pengguna</p>
                    @endif
                </div>
            </div>

            <!-- Top Facilities -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Fasilitas Paling Sering Dilaporkan</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach($topFacilities as $facility)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{ $facility->fasilitas_nama }}
                                        <span class="badge badge-warning float-right">{{ $facility->total_reports }}</span>
                                    </a>
                                    <span class="product-description">
                                        ID: {{ $facility->fasilitas_id }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Budget Planning Section -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Analisis untuk Perencanaan Anggaran</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Kategori Kerusakan</h5>
                            <canvas id="damageCategoryChart" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <h5>Prioritas Perbaikan</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Prioritas</th>
                                            <th>Jumlah</th>
                                            <th>% dari Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            // Damage Trends Chart
            var months = [];
            var counts = [];
            
            @foreach($damageTrends as $trend)
                months.push('{{ date("M Y", mktime(0, 0, 0, $trend->month, 1, $trend->year)) }}');
                counts.push({{ $trend->total }});
            @endforeach

            var ctx = document.getElementById('damageTrendsChart').getContext('2d');
            var damageTrendsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Jumlah Laporan Kerusakan',
                        data: counts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Load damage category data via AJAX
            $.get("{{ route('admin.dashboard.damage-categories') }}", function(data) {
                var damageCategoryCtx = document.getElementById('damageCategoryChart').getContext('2d');
                var damageCategoryChart = new Chart(damageCategoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.data,
                            backgroundColor: [
                                '#FF6384',
                                '#36A2EB',
                                '#FFCE56',
                                '#4BC0C0',
                                '#9966FF',
                                '#FF9F40'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            }
                        }
                    }
                });
            });

            // Load priority data via AJAX
            $.get("{{ route('admin.dashboard.priority-stats') }}", function(data) {
                var tableBody = $('.table-responsive tbody');
                tableBody.empty();
                
                data.forEach(function(item) {
                    tableBody.append(`
                        <tr>
                            <td>${item.priority_name}</td>
                            <td>${item.count}</td>
                            <td>${item.percentage}%</td>
                        </tr>
                    `);
                });
            });
        });
    </script>
@endpush