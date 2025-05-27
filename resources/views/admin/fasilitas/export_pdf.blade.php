<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Fasilitas</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 4px 3px;
        }

        th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-14 {
            font-size: 14pt;
        }

        .mb-2 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h3 class="text-center font-14">LAPORAN DATA FASILITAS</h3>
    <br>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
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
            @forelse ($fasilitas as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
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
                    <td colspan="8" class="text-center">Tidak ada data fasilitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>