<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 12px;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
        }
        .badge-info {
            background-color: #17a2b8;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .badge-primary {
            background-color: #007bff;
        }
        .badge-success {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <h2 class="text-center">{{ $title }}</h2>
    <p class="text-center">Tanggal: {{ date('d/m/Y H:i:s') }}</p>
    
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Pelapor</th>
                <th>Periode</th>
                <th>Fasilitas</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $lpr)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $lpr->judul }}</td>
                <td>{{ $lpr->user->nama }}</td>
                <td>{{ $lpr->periode->periode_nama }}</td>
                <td>{{ $lpr->fasilitas->fasilitas_nama ?? '-' }}</td>
                <td>{{ $lpr->bobotPrioritas->bobot_nama ?? '-' }}</td>
                <td>
                    @if($lpr->status == 'menunggu')
                        <span class="badge badge-warning">Menunggu</span>
                    @elseif($lpr->status == 'diterima')
                        <span class="badge badge-info">Diterima</span>
                    @elseif($lpr->status == 'ditolak')
                        <span class="badge badge-danger">Ditolak</span>
                    @elseif($lpr->status == 'diproses')
                        <span class="badge badge-primary">Diproses</span>
                    @elseif($lpr->status == 'selesai')
                        <span class="badge badge-success">Selesai</span>
                    @endif
                </td>
                <td>{{ $lpr->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>