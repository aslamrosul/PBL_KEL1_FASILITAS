<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi</th>
                <th>Kode Ruang</th>
                <th>Nama Ruang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ruangs as $index => $ruang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $ruang->lantai->gedung->gedung_nama ?? '-' }} - 
                        Lantai {{ $ruang->lantai->lantai_nomor }}
                    </td>
                    <td>{{ $ruang->ruang_kode }}</td>
                    <td>{{ $ruang->ruang_nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: Sistem Informasi</p>
    </div>
</body>
</html>