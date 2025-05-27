<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kriteria</title>
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kriteria</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kriterias as $index => $kriteria)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kriteria->kriteria_kode }}</td>
                    <td>{{ $kriteria->kriteria_nama }}</td>
                    <td>{{ $kriteria->bobot }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data kriteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>