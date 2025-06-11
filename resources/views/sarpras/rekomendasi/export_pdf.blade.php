<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title }}</title>
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
            padding: 4px 3px;
        }

        th {
            text-align: left;
        }

        .d-block {
            display: block;
        }

        img.image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            padding: 5px 1px 5px 1px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ public_path('polinema-bw.jpeg') }}" class="image">
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>
    <h3 class="text-center">{{ $title }}</h3>
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Pengguna</th>
                <th>Level</th>
                <th>Fasilitas</th>
                <th>Prioritas</th>
                <th>Tanggal Lapor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $index => $laporan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $laporan->judul }}</td>
                    <td>{{ $laporan->deskripsi }}</td>
                    <td>{{ $laporan->user ? $laporan->user->nama : '-' }}</td>
                    <td>{{ $laporan->user && $laporan->user->level ? $laporan->user->level->level_nama : '-' }}</td>
                    <td>{{ $laporan->fasilitas && $laporan->fasilitas->barang ? $laporan->fasilitas->barang->barang_nama : '-' }}</td>
                    <td>{{ $laporan->bobotPrioritas ? $laporan->bobotPrioritas->nama : '-' }}</td>
                    <td>{{ $laporan->tanggal_lapor->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data rekomendasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>