<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Klasifikasi</title>
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
    <h3 class="text-center font-14">LAPORAN DATA KLASIFIKASI</h3>
    <br>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Klasifikasi</th>
                <th>Nama Klasifikasi</th>
            </tr>
        </thead>
        <tbody>
@forelse ($klasifikasis as $index => $klasifikasi)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $klasifikasi->klasifikasi_kode }}</td>
                    <td>{{ $klasifikasi->klasifikasi_nama }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data klasifikasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
