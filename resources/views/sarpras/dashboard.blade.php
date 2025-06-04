@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Dashboard Sarana Prasarana</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Maintenance Statistics -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $maintenanceStats['total'] }}</h3>
                                    <p>Total Perbaikan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <a href="{{ route('sarpras.laporan.index') }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $maintenanceStats['ongoing'] }}</h3>
                                    <p>Sedang Diproses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <a href="{{ route('sarpras.laporan.index', ['status' => 'diproses']) }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $maintenanceStats['completed'] }}</h3>
                                    <p>Selesai</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <a href="{{ route('sarpras.laporan.index', ['status' => 'selesai']) }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $maintenanceStats['rejected'] }}</h3>
                                    <p>Ditolak</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <a href="{{ route('sarpras.laporan.index', ['status' => 'ditolak']) }}" class="small-box-footer">
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
        <!-- Facility Conditions -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kondisi Fasilitas</h3>
                </div>
                <div class="card-body">
                    <canvas id="facilityConditionChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Repair Frequency -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Frekuensi Perbaikan Fasilitas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fasilitas</th>
                                    <th>Jumlah Laporan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($repairFrequency as $facility)
                                    <tr>
                                        <td>{{ $facility->fasilitas_nama }}</td>
                                        <td>{{ $facility->report_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Average Repair Time -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Waktu Perbaikan Rata-rata</h3>
                </div>
                <div class="card-body text-center">
                    @if($avgRepairTime->avg_hours)
                        <h1>{{ number_format($avgRepairTime->avg_hours, 1) }} <small>jam</small></h1>
                        <p class="text-muted">Waktu rata-rata dari mulai perbaikan hingga selesai</p>
                    @else
                        <p class="text-muted">Belum ada data waktu perbaikan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Satisfaction by Facility -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kepuasan Pengguna per Fasilitas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fasilitas</th>
                                    <th>Rating Rata-rata</th>
                                    <th>Jumlah Ulasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($satisfactionByFacility as $item)
                                    <tr>
                                        <td>{{ $item->fasilitas_nama }}</td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($item->avg_rating))
                                                    <i class="fas fa-star text-warning"></i>
                                                @elseif($i - 0.5 <= $item->avg_rating)
                                                    <i class="fas fa-star-half-alt text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                            ({{ number_format($item->avg_rating, 1) }})
                                        </td>
                                        <td>{{ $item->feedback_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Long-term Maintenance Planning -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Perencanaan Pemeliharaan Jangka Panjang</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Trend Kerusakan Tahunan</h5>
                            <canvas id="yearlyDamageTrendChart" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <h5>Fasilitas Prioritas</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Fasilitas</th>
                                            <th>Frekuensi Kerusakan</th>
                                            <th>Rating Kepuasan</th>
                                            <th>Prioritas</th>
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
            // Facility Condition Chart
            var conditionLabels = [];
            var conditionData = [];
            var conditionColors = [];
            
            @foreach($facilityConditions as $condition)
                conditionLabels.push('{{ $condition->status }}');
                conditionData.push({{ $condition->total }});
                
                // Assign colors based on status
                @if($condition->status == 'baik')
                    conditionColors.push('#28a745');
                @elseif($condition->status == 'rusak_ringan')
                    conditionColors.push('#ffc107');
                @elseif($condition->status == 'rusak_berat')
                    conditionColors.push('#dc3545');
                @else
                    conditionColors.push('#6c757d');
                @endif
            @endforeach

            var conditionCtx = document.getElementById('facilityConditionChart').getContext('2d');
            var conditionChart = new Chart(conditionCtx, {
                type: 'doughnut',
                data: {
                    labels: conditionLabels,
                    datasets: [{
                        data: conditionData,
                        backgroundColor: conditionColors
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

            // Load yearly damage trend data via AJAX
            $.get("{{ route('sarpras.dashboard.yearly-trend') }}", function(data) {
                var yearlyTrendCtx = document.getElementById('yearlyDamageTrendChart').getContext('2d');
                var yearlyTrendChart = new Chart(yearlyTrendCtx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Jumlah Laporan Kerusakan',
                            data: data.data,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });

            // Load priority facilities data via AJAX
            $.get("{{ route('sarpras.dashboard.priority-facilities') }}", function(data) {
                var tableBody = $('.table-responsive tbody');
                tableBody.empty();
                
                data.forEach(function(facility) {
                    // Determine priority badge
                    var priorityBadge = '';
                    if(facility.priority === 'Tinggi') {
                        priorityBadge = '<span class="badge badge-danger">Tinggi</span>';
                    } else if(facility.priority === 'Sedang') {
                        priorityBadge = '<span class="badge badge-warning">Sedang</span>';
                    } else {
                        priorityBadge = '<span class="badge badge-secondary">Rendah</span>';
                    }
                    
                    tableBody.append(`
                        <tr>
                            <td>${facility.name}</td>
                            <td>${facility.report_count}</td>
                            <td>
                                ${facility.rating_stars}
                                (${facility.avg_rating})
                            </td>
                            <td>${priorityBadge}</td>
                        </tr>
                    `);
                });
            });
        });
    </script>
@endpush