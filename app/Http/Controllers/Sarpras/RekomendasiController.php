<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\FasilitasModel;
use App\Models\KriteriaModel;
use App\Models\BobotPrioritasModel;
use App\Models\RekomendasiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class RekomendasiController extends Controller
{
    // Index untuk semua rekomendasi
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Rekomendasi Prioritas Perbaikan',
            'list' => ['Home', 'Rekomendasi']
        ];

        $page = (object) [
            'title' => 'Daftar rekomendasi prioritas perbaikan fasilitas'
        ];

        $activeMenu = 'rekomendasi';

        return view('sarpras.rekomendasi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Index untuk rekomendasi mahasiswa
  // Contoh untuk rekomendasi mahasiswa
public function indexMahasiswa()
{
    $breadcrumb = (object) [
        'title' => 'Rekomendasi Mahasiswa',
        'list' => ['Home', 'Rekomendasi', 'Mahasiswa']
    ];

    $page = (object) [
        'title' => 'Daftar rekomendasi prioritas perbaikan dari mahasiswa'
    ];

    $activeMenu = 'rekomendasi-mahasiswa';

    return view('sarpras.rekomendasi.index', [ // Gunakan view yang sama
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu,
        'userLevel' => 2 // Filter untuk mahasiswa
    ]);
}

    // Index untuk rekomendasi dosen
    public function indexDosen()
    {
        $breadcrumb = (object) [
            'title' => 'Rekomendasi Dosen',
            'list' => ['Home', 'Rekomendasi', 'Dosen']
        ];

        $page = (object) [
            'title' => 'Daftar rekomendasi prioritas perbaikan dari dosen'
        ];

        $activeMenu = 'rekomendasi-dosen';

        return view('sarpras.rekomendasi.dosen', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Index untuk rekomendasi tendik
    public function indexTendik()
    {
        $breadcrumb = (object) [
            'title' => 'Rekomendasi Tendik',
            'list' => ['Home', 'Rekomendasi', 'Tendik']
        ];

        $page = (object) [
            'title' => 'Daftar rekomendasi prioritas perbaikan dari tendik'
        ];

        $activeMenu = 'rekomendasi-tendik';

        return view('sarpras.rekomendasi.tendik', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // List data untuk semua rekomendasi
    public function list(Request $request)
    {
        $laporans = LaporanModel::with(['fasilitas.barang.klasifikasi', 'user.level', 'bobotPrioritas', 'rekomendasi'])
            ->where('status', 'diterima')
            ->select('t_laporan.*');

        return DataTables::of($laporans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($laporan) {
                // Tombol Detail
                $btn = '<button onclick="modalAction(\'' . url('/sarpras/rekomendasi/' . $laporan->laporan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm me-1">
                    <i class="fa fa-eye"></i> 
                </button>';

               
                // Tombol Assign (hanya jika status == 'diterima')
                if ($laporan->status == 'diterima') {
                    $btn .= '<button onclick="modalAction(\'' . url('/sarpras/laporan/' . $laporan->laporan_id . '/assign_ajax') . '\')" class="btn btn-success btn-sm me-1">
                        <i class="fa fa-briefcase"></i> 
                    </button>';
                }

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // List data untuk rekomendasi mahasiswa
    public function listMahasiswa(Request $request)
    {
        $laporans = LaporanModel::with(['fasilitas.barang.klasifikasi', 'user.level', 'bobotPrioritas', 'rekomendasi'])
            ->where('status', 'diterima')
            ->whereHas('user', function ($query) {
                $query->where('level_id', 2); // Level mahasiswa
            })
            ->select('t_laporan.*');

        return DataTables::of($laporans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($laporan) {
                 $btn = '<button onclick="modalAction(\'' . url('/sarpras/rekomendasi-mahasiswa/' . $laporan->laporan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm me-1">
                    <i class="fa fa-eye"></i> 
                </button>';

               
                // Tombol Assign (hanya jika status == 'diterima')
                if ($laporan->status == 'diterima') {
                    $btn .= '<button onclick="modalAction(\'' . url('/sarpras/laporan/' . $laporan->laporan_id . '/assign_ajax') . '\')" class="btn btn-success btn-sm me-1">
                        <i class="fa fa-briefcase"></i> 
                    </button>';
                }

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // List data untuk rekomendasi dosen
    public function listDosen(Request $request)
    {
        $laporans = LaporanModel::with(['fasilitas.barang.klasifikasi', 'user.level', 'bobotPrioritas', 'rekomendasi'])
            ->where('status', 'diterima')
            ->whereHas('user', function ($query) {
                $query->where('level_id', 3); // Level dosen
            })
            ->select('t_laporan.*');

        return DataTables::of($laporans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($laporan) {
                 $btn = '<button onclick="modalAction(\'' . url('/sarpras/rekomendasi-dosen/' . $laporan->laporan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm me-1">
                    <i class="fa fa-eye"></i> 
                </button>';

               
                // Tombol Assign (hanya jika status == 'diterima')
                if ($laporan->status == 'diterima') {
                    $btn .= '<button onclick="modalAction(\'' . url('/sarpras/laporan/' . $laporan->laporan_id . '/assign_ajax') . '\')" class="btn btn-success btn-sm me-1">
                        <i class="fa fa-briefcase"></i> 
                    </button>';
                }

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // List data untuk rekomendasi tendik
    public function listTendik(Request $request)
    {
        $laporans = LaporanModel::with(['fasilitas.barang.klasifikasi', 'user.level', 'bobotPrioritas', 'rekomendasi'])
            ->where('status', 'diterima')
            ->whereHas('user', function ($query) {
                $query->where('level_id', 4); // Level tendik
            })
            ->select('t_laporan.*');

        return DataTables::of($laporans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($laporan) {
                 $btn = '<button onclick="modalAction(\'' . url('/sarpras/rekomendasi-tendik/' . $laporan->laporan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm me-1">
                    <i class="fa fa-eye"></i> 
                </button>';

               
                // Tombol Assign (hanya jika status == 'diterima')
                if ($laporan->status == 'diterima') {
                    $btn .= '<button onclick="modalAction(\'' . url('/sarpras/laporan/' . $laporan->laporan_id . '/assign_ajax') . '\')" class="btn btn-success btn-sm me-1">
                        <i class="fa fa-briefcase"></i> 
                    </button>';
                }

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Show detail laporan
    // Show detail laporan
    public function show($id)
    {
        $laporan = LaporanModel::with(['fasilitas.barang.klasifikasi', 'user.level', 'bobotPrioritas', 'rekomendasi'])
            ->find($id);

        if (!$laporan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return view('sarpras.rekomendasi.show_ajax', compact('laporan'));
    }

    // Show AHP and TOPSIS calculation details
    // app/Http/Controllers/Sarpras/RekomendasiController.php

  public function showDetailPerhitungan($id)
    {
        $laporan = LaporanModel::with([
            'rekomendasi', 
            'fasilitas', 
            'fasilitas.barang', 
            'fasilitas.barang.klasifikasi',
            'user.level'
        ])->find($id);

        if (!$laporan || !$laporan->rekomendasi) {
            return response()->json([
                'status' => false,
                'message' => 'Data laporan atau rekomendasi tidak ditemukan'
            ], 404);
        }

        $batchLaporans = LaporanModel::with('rekomendasi')
            ->where('periode_id', $laporan->periode_id)
            ->where('status', 'diterima')
            ->whereHas('rekomendasi')
            ->get();

        $data = [
            'laporan' => $laporan,
            'kriteria' => KriteriaModel::all(),
            'nilai_kriteria' => $laporan->rekomendasi->nilai_kriteria,
            'matriks_keputusan' => $this->buildMatriksKeputusan($batchLaporans),
            'matriks_normalisasi' => $this->buildMatriksNormalisasi($batchLaporans),
            'matriks_terbobot' => $this->buildMatriksTerbobot($batchLaporans),
            'solusi_ideal' => $this->buildSolusiIdeal($batchLaporans),
            'hasil_akhir' => $this->buildHasilAkhir($batchLaporans)
        ];

        return view('sarpras.rekomendasi.detail_perhitungan', $data);
    }

    private function buildMatriksKeputusan($laporans)
    {
        $matriks = [];
        foreach ($laporans as $lap) {
            $nilai = $lap->rekomendasi->nilai_kriteria;
            $matriks[] = array_merge(['laporan_id' => $lap->laporan_id, 'judul' => $lap->judul], $nilai);
        }
        return $matriks;
    }

    private function buildMatriksNormalisasi($laporans)
    {
        $matriks = $this->buildMatriksKeputusan($laporans);
        $kriteria = KriteriaModel::all();
        $normalized = [];

        foreach ($kriteria as $k) {
            $kode = strtolower($k->kriteria_kode);
            $kolom = array_column($matriks, $kode);
            $sumSquares = sqrt(array_sum(array_map(fn($x) => $x * $x, $kolom)));

            foreach ($matriks as $i => $row) {
                $normalized[$i][$kode] = $sumSquares != 0 ? $row[$kode] / $sumSquares : 0;
            }
        }

        foreach ($matriks as $i => $row) {
            $normalized[$i]['laporan_id'] = $row['laporan_id'];
            $normalized[$i]['judul'] = $row['judul'];
        }

        return $normalized;
    }

    private function buildMatriksTerbobot($laporans)
    {
        $normalized = $this->buildMatriksNormalisasi($laporans);
        $kriteria = KriteriaModel::all();
        $terbobot = [];

        foreach ($normalized as $i => $row) {
            $terbobot[$i] = ['laporan_id' => $row['laporan_id'], 'judul' => $row['judul']];
            foreach ($kriteria as $k) {
                $kode = strtolower($k->kriteria_kode);
                $terbobot[$i][$kode] = $row[$kode] * $k->bobot;
            }
        }

        return $terbobot;
    }

    private function buildSolusiIdeal($laporans)
    {
        $terbobot = $this->buildMatriksTerbobot($laporans);
        $kriteria = KriteriaModel::all();
        $positif = [];
        $negatif = [];

        foreach ($kriteria as $k) {
            $kode = strtolower($k->kriteria_kode);
            $kolom = array_column($terbobot, $kode);
            $positif[$kode] = $k->kriteria_jenis == 'benefit' ? max($kolom) : min($kolom);
            $negatif[$kode] = $k->kriteria_jenis == 'benefit' ? min($kolom) : max($kolom);
        }

        return ['positif' => $positif, 'negatif' => $negatif];
    }

    private function buildHasilAkhir($laporans)
    {
        $terbobot = $this->buildMatriksTerbobot($laporans);
        $solusiIdeal = $this->buildSolusiIdeal($laporans);
        $hasil = [];

        foreach ($terbobot as $i => $row) {
            $jarakPositif = 0;
            $jarakNegatif = 0;

            foreach ($row as $kode => $nilai) {
                if ($kode == 'laporan_id' || $kode == 'judul') continue;
                $jarakPositif += pow($nilai - $solusiIdeal['positif'][$kode], 2);
                $jarakNegatif += pow($nilai - $solusiIdeal['negatif'][$kode], 2);
            }

            $jarakPositif = sqrt($jarakPositif);
            $jarakNegatif = sqrt($jarakNegatif);

            $hasil[] = [
                'laporan_id' => $row['laporan_id'],
                'judul' => $row['judul'],
                'jarak_positif' => $jarakPositif,
                'jarak_negatif' => $jarakNegatif,
                'skor_akhir' => $jarakNegatif / ($jarakPositif + $jarakNegatif)
            ];
        }

        usort($hasil, fn($a, $b) => $b['skor_akhir'] <=> $a['skor_akhir']);
        return $hasil;
    }
    public function export_excel()
    {
        return $this->generateExcel(null, 'Data_Rekomendasi');
    }

    public function export_excel_mahasiswa()
    {
        return $this->generateExcel(2, 'Data_Rekomendasi_Mahasiswa');
    }

    public function export_excel_dosen()
    {
        return $this->generateExcel(3, 'Data_Rekomendasi_Dosen');
    }

    public function export_excel_tendik()
    {
        return $this->generateExcel(4, 'Data_Rekomendasi_Tendik');
    }

    private function generateExcel($level_id = null, $filename_prefix = 'Data_Rekomendasi')
    {
        $laporans = LaporanModel::with(['fasilitas.barang.klasifikasi', 'user.level', 'bobotPrioritas', 'rekomendasi'])
            ->where('status', 'diterima')
            ->when($level_id, function ($query, $level_id) {
                $query->whereHas('user', function ($q) use ($level_id) {
                    $q->where('level_id', $level_id);
                });
            })
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = ['No', 'Judul', 'Deskripsi', 'Pengguna', 'Level', 'Fasilitas', 'Prioritas', 'Tanggal Lapor'];
        $col = 'A';
        foreach ($header as $h) {
            $sheet->setCellValue($col . '1', $h);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $col++;
        }

        $row = 2;
        $no = 1;
        foreach ($laporans as $laporan) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $laporan->judul);
            $sheet->setCellValue('C' . $row, $laporan->deskripsi);
            $sheet->setCellValue('D' . $row, $laporan->user->nama ?? '-');
            $sheet->setCellValue('E' . $row, $laporan->user->level->level_nama ?? '-');
            $sheet->setCellValue('F' . $row, $laporan->fasilitas->barang->barang_nama ?? '-');
            $sheet->setCellValue('G' . $row, $laporan->bobotPrioritas->nama ?? '-');
            $sheet->setCellValue('H' . $row, $laporan->tanggal_lapor->format('Y-m-d H:i:s'));
            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setTitle($filename_prefix);
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = $filename_prefix . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf_by_level($level_id = null, $title_prefix = 'Laporan Data Rekomendasi', $filename_prefix = 'Data_Rekomendasi')
    {
        $laporansQuery = LaporanModel::with([
            'fasilitas.barang.klasifikasi',
            'user.level',
            'bobotPrioritas',
            'rekomendasi'
        ])
            ->where('status', 'diterima')
            ->select('t_laporan.*');

        if ($level_id !== null) {
            $laporansQuery->whereHas('user', function ($query) use ($level_id) {
                $query->where('level_id', $level_id);
            });
        }

        $laporans = $laporansQuery->get();

        $data = [
            'laporans' => $laporans,
            'title' => $title_prefix
        ];

        $pdf = Pdf::loadView('sarpras.rekomendasi.export_pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream($filename_prefix . '_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function export_pdf()
    {
        return $this->export_pdf_by_level();
    }

    public function export_pdf_mahasiswa()
    {
        return $this->export_pdf_by_level(2, 'Laporan Data Rekomendasi Mahasiswa', 'Data_Rekomendasi_Mahasiswa');
    }

    public function export_pdf_dosen()
    {
        return $this->export_pdf_by_level(3, 'Laporan Data Rekomendasi Dosen', 'Data_Rekomendasi_Dosen');
    }

    public function export_pdf_tendik()
    {
        return $this->export_pdf_by_level(4, 'Laporan Data Rekomendasi Tendik', 'Data_Rekomendasi_Tendik');
    }
}
