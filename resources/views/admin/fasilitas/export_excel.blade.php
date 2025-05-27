<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Fasilitas</title>
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Ruang</th>
                <th>Barang</th>
                <th>Kode Fasilitas</th>
                <th>Nama Fasilitas</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Tahun Pengadaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fasilitas as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->ruang ? $item->ruang->ruang_nama : '-' }}</td>
                    <td>{{ $item->barang ? $item->barang->barang_nama : '-' }}</td>
                    <td>{{ $item->fasilitas_kode }}</td>
                    <td>{{ $item->fasilitas_nama }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->tahun_pengadaan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data fasilitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>