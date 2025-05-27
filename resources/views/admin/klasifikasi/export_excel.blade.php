<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Klasifikasi</title>
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Klasifikasi</th>
                <th>Nama Klasifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $klasifikasi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $klasifikasi->klasifikasi_kode }}</td>
                    <td>{{ $klasifikasi->klasifikasi_nama }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada data klasifikasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
