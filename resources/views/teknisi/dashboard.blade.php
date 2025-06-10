@extends('layouts.template')

@section('content')
<div class="row">
    <!-- Header Card -->
    <div class="col-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Dashboard Teknisi</h4>
                <div>
                    <span class="badge bg-primary badge-pill">Teknisi: {{ auth()->user()->nama }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Repair Statistics -->
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-box bg-primary text-white">
                            <div class="stat-content">
                                <h3>{{ $repairStats['total'] }}</h3>
                                <p>Total Perbaikan</p>
                                <i class="fa fa-wrench stat-icon"></i>
                            </div>
                            <a href="{{ url('teknisi/perbaikan') }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-box bg-warning text-dark">
                            <div class="stat-content">
                                <h3>{{ $repairStats['waiting'] }}</h3>
                                <p>Menunggu</p>
                                <i class="fa fa-clock-o stat-icon"></i>
                            </div>
                            <a href="{{ url('teknisi/perbaikan') }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-box bg-info text-white">
                            <div class="stat-content">
                                <h3>{{ $repairStats['in_progress'] }}</h3>
                                <p>Diproses</p>
                                <i class="fa fa-gears stat-icon"></i>
                            </div>
                            <a href="{{ url('teknisi/perbaikan') }}" class="stat-footer">
                                More Info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-box bg-success text-white">
                            <div class="stat-content">
                                <h3>{{ $repairStats['completed'] }}</h3>
                                <p>Selesai</p>
                                <i class="fa fa-check-circle-o stat-icon"></i>
                            </div>
                            <a href="{{ url('teknisi/perbaikan/riwayat') }}" class="stat-footer">
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
    <!-- Latest Repairs -->
    <div class="col-lg-8 mb-4">
        <div class="card dashboard-card">
            <div class="card-header">
                <h4 class="card-title">Perbaikan Terbaru yang Perlu Ditangani</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Laporan</th>
                                <th>Fasilitas</th>
                                <th>Tanggal Mulai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestRepairs as $repair)
                                <tr>
                                    <td>{{ $repair->perbaikan_id }}</td>
                                    <td>{{ $repair->laporan->judul }}</td>
                                    <td>{{ $repair->laporan->fasilitas->fasilitas_nama ?? '-' }}</td>
                                    <td>{{ $repair->tanggal_mulai->format('d M Y') }}</td>
                                    <td>
                                        @if($repair->status == 'menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($repair->status == 'diproses')
                                            <span class="badge badge-primary">Diproses</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('teknisi/perbaikan/' . $repair->perbaikan_id . '/edit_ajax') }}" 
                                           class="btn btn-sm btn-primary" 
                                           onclick="modalAction(this.href); return false;">
                                            <i class="fa fa-wrench"></i> Proses
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada perbaikan yang perlu ditangani</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card dashboard-card mb-4">
            <div class="card-header">
                <h4 class="card-title">Aksi Cepat</h4>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ url('teknisi/perbaikan') }}" class="btn btn-primary btn-lg">
                        <i class="fa fa-list me-2"></i> Lihat Semua Perbaikan
                    </a>
                    <a href="{{ url('teknisi/perbaikan/riwayat') }}" class="btn btn-success btn-lg">
                        <i class="fa fa-history me-2"></i> Riwayat Perbaikan
                    </a>
                </div>
            </div>
        </div>

        <!-- Repair Status Chart -->
        <div class="card dashboard-card">
            <div class="card-header">
                <h4 class="card-title">Status Perbaikan</h4>
            </div>
            <div class="card-body">
                <canvas id="repairStatusChart" height="250"></canvas>
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

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
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
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add fade-in animation
            $('.dashboard-card, .stat-box').addClass('fade-in');

            // Repair Status Chart
            var repairStatusCtx = document.getElementById('repairStatusChart').getContext('2d');
            new Chart(repairStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Diproses', 'Selesai'],
                    datasets: [{
                        data: [
                            {{ $repairStats['waiting'] }}, 
                            {{ $repairStats['in_progress'] }}, 
                            {{ $repairStats['completed'] }}
                        ],
                        backgroundColor: [
                            '#ffc107',
                            '#0dcaf0',
                            '#198754'
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

            // Modal action function from perbaikan index
            function modalAction(url = '') {
                $('#myModal').load(url, function () {
                    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                        keyboard: false,
                        backdrop: 'static'
                    });
                    myModal.show();
                });
            }

            // Add modal container to the page
            $('body').append('<div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true"></div>');
            
            // Make modalAction available globally
            window.modalAction = modalAction;
        });
    </script>
@endpush