 @extends('layouts.template')

@section('content')
<div class="row">
    <!-- Header Card -->
    <div class="col-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Dashboard Admin</h4>
                <div>
                    @if($currentPeriod)
                        <span class="badge bg-primary badge-pill">Periode Aktif: {{ $currentPeriod->periode_nama }}</span>
                    @else
                        <span class="badge bg-warning badge-pill">Tidak ada periode aktif</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Report Statistics -->
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-box bg-primary text-white">
                            <div class="stat-content">
                                <h3>{{ $reportStats['total'] }}</h3>
                                <p>Total Laporan</p>
                                <i class="fa fa-file-text-o stat-icon"></i>
                            </div>
                            <a href="{{ route('admin.laporan.index') }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-box bg-warning text-dark">
                            <div class="stat-content">
                                <h3>{{ $reportStats['menunggu'] }}</h3>
                                <p>Menunggu</p>
                                <i class="fa fa-clock-o stat-icon"></i>
                            </div>
                            <a href="{{ route('admin.laporan.index', ['status' => 'menunggu']) }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-box bg-info text-white">
                            <div class="stat-content">
                                <h3>{{ $reportStats['diterima'] }}</h3>
                                <p>Diterima</p>
                                <i class="fa fa-check stat-icon"></i>
                            </div>
                            <a href="{{ route('admin.laporan.index', ['status' => 'diterima']) }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-box bg-danger text-white">
                            <div class="stat-content">
                                <h3>{{ $reportStats['rejected'] }}</h3>
                                <p>Ditolak</p>
                                <i class="fa fa-times stat-icon"></i>
                            </div>
                            <a href="{{ route('admin.laporan.index', ['status' => 'ditolak']) }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-box bg-secondary text-white">
                            <div class="stat-content">
                                <h3>{{ $reportStats['processed'] }}</h3>
                                <p>Diproses</p>
                                <i class="fa fa-wrench stat-icon"></i>
                            </div>
                            <a href="{{ route('admin.laporan.index', ['status' => 'diproses']) }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="stat-box bg-success text-white">
                            <div class="stat-content">
                                <h3>{{ $reportStats['completed'] }}</h3>
                                <p>Selesai</p>
                                <i class="fa fa-check-circle-o stat-icon"></i>
                            </div>
                            <a href="{{ route('admin.laporan.index', ['status' => 'selesai']) }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
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
    <div class="col-lg-8 mb-4">
        <div class="card dashboard-card">
            <div class="card-header">
                <h4 class="card-title">Tren Kerusakan Fasilitas (6 Bulan Terakhir)</h4>
            </div>
            <div class="card-body">
                <canvas id="damageTrendsChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- User Satisfaction & Top Facilities -->
    <div class="col-lg-4">
        <div class="card dashboard-card mb-4">
            <div class="card-header">
                <h4 class="card-title">Kepuasan Pengguna</h4>
            </div>
            <div class="card-body text-center">
                @if($satisfactionStats->total_feedback > 0)
                    <div class="rating-display mb-3">
                        <h1 class="rating-score">{{ number_format($satisfactionStats->average_rating, 1) }}</h1>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($satisfactionStats->average_rating))
                                    <i class="fa fa-star text-warning"></i>
                                @elseif($i - 0.5 <= $satisfactionStats->average_rating)
                                    <i class="fa fa-star-half-o text-warning"></i>
                                @else
                                    <i class="fa fa-star-o text-warning"></i>
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

        <div class="card dashboard-card">
            <div class="card-header">
                <h4 class="card-title">Fasilitas Paling Sering Dilaporkan</h4>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($topFacilities as $facility)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <a href="javascript:void(0)" class="text-dark">{{ $facility->fasilitas_nama }}</a>
                                <div class="text-muted small">ID: {{ $facility->fasilitas_id }}</div>
                            </div>
                            <span class="badge bg-warning badge-pill">{{ $facility->total_reports }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Budget Planning Section -->
<div class="row">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header">
                <h4 class="card-title">Analisis untuk Perencanaan Anggaran</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5>Kategori Kerusakan</h5>
                        <canvas id="damageCategoryChart" height="200"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h5>Prioritas Perbaikan</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Prioritas</th>
                                        <th>Jumlah</th>
                                        <th>% dari Total</th>
                                    </tr>
                                </thead>
                                <tbody id="priorityTableBody">
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
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .dashboard-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .stat-box {
            border-radius: 8px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .stat-box:hover {
            transform: scale(1.02);
        }

        .stat-content {
            position: relative;
            z-index: 1;
        }

        .stat-box h3 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-box p {
            margin: 0;
            font-size: 1rem;
            opacity: 0.9;
        }

        .stat-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 40px;
            opacity: 0.2;
        }

        .stat-footer {
            display: block;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.05);
            color: inherit;
            text-align: center;
            border-radius: 0 0 8px 8px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .stat-footer:hover {
            background-color: rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .badge-pill {
            font-size: 0.9rem;
            padding: 8px 12px;
        }

        .rating-score {
            font-size: 3rem;
            color: #1a1a1a;
            font-weight: bold;
        }

        .stars i {
            font-size: 1.2rem;
            margin: 0 2px;
        }

        .list-group-item {
            transition: background-color 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .table-light {
            background-color: #f1f3f5;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .stat-box h3 {
                font-size: 1.5rem;
            }
            .card-title {
                font-size: 1.1rem;
            }
            .rating-score {
                font-size: 2.5rem;
            }
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add fade-in animation
            $('.dashboard-card, .stat-box').addClass('fade-in');

            // Damage Trends Chart
            var months = [];
            var counts = [];
            
            @foreach($damageTrends as $trend)
                months.push('{{ date("M Y", mktime(0, 0, 0, $trend->month, 1, $trend->year)) }}');
                counts.push({{ $trend->total }});
            @endforeach

            var ctx = document.getElementById('damageTrendsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Jumlah Laporan Kerusakan',
                        data: counts,
                        backgroundColor: 'rgba(13, 110, 253, 0.2)',
                        borderColor: '#0d6efd',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0d6efd',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: { size: 14, weight: 'bold' }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0,0,0,0.8)'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 },
                            grid: { color: 'rgba(0,0,0,0.1)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Damage Category Chart
            $.get("{{ route('admin.dashboard.damage-categories') }}", function(data) {
                var damageCategoryCtx = document.getElementById('damageCategoryChart').getContext('2d');
                new Chart(damageCategoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.data,
                            backgroundColor: [
                                '#dc3545',
                                '#0d6efd',
                                '#ffc107',
                                '#20c997',
                                '#6610f2',
                                '#fd7e14'
                            ],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { font: { size: 12, weight: 'bold' }, padding: 20 }
                            },
                            tooltip: { backgroundColor: 'rgba(0,0,0,0.8)' }
                        },
                        cutout: '60%'
                    }
                });
            });

            // Priority Stats
            $.get("{{ route('admin.dashboard.priority-stats') }}", function(data) {
                var tableBody = $('#priorityTableBody');
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
```