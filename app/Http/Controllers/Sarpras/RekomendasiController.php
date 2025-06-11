<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\FasilitasModel;
use App\Models\KriteriaModel;
use App\Models\BobotPrioritasModel;
use App\Models\RekomendasiModel;
use App\Services\TopsisService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $laporan = LaporanModel::with(['fasilitas.barang.klasifikasi', 'rekomendasi'])->findOrFail($id);
        $batchLaporans = LaporanModel::with(['fasilitas.barang.klasifikasi', 'rekomendasi'])
            ->where('periode_id', $laporan->periode_id)
            ->where('status', 'diterima')
            ->get();

        if ($batchLaporans->isEmpty()) {
            Log::warning('No accepted laporan found for periode_id: ' . $laporan->periode_id);
            return view('sarpras.rekomendasi.detail_perhitungan', [
                'laporan' => $laporan,
                'kriteria' => KriteriaModel::all(),
                'matriks_keputusan' => [],
                'matriks_normalisasi' => [],
                'matriks_terbobot' => [],
                'solusi_ideal_positif' => [],
                'solusi_ideal_negatif' => [],
                'hasil_akhir' => [],
                'bobot_prioritas' => BobotPrioritasModel::all()->keyBy('bobot_id')
            ]);
        }

        $matriksKeputusan = $this->buildMatriksKeputusan($batchLaporans);
        $matriksNormalisasi = $this->buildMatriksNormalisasi($matriksKeputusan);
        $matriksTerbobot = $this->buildMatriksTerbobot($matriksNormalisasi);
        $solusiIdeal = $this->buildSolusiIdeal($matriksTerbobot);
        $hasilAkhir = $this->buildHasilAkhir(
            $matriksTerbobot,
            $solusiIdeal['positif'],
            $solusiIdeal['negatif'],
            $matriksKeputusan
        );

        return view('sarpras.rekomendasi.detail_perhitungan', [
            'laporan' => $laporan,
            'kriteria' => KriteriaModel::all(),
            'matriks_keputusan' => $matriksKeputusan,
            'matriks_normalisasi' => $matriksNormalisasi,
            'matriks_terbobot' => $matriksTerbobot,
            'solusi_ideal_positif' => $solusiIdeal['positif'],
            'solusi_ideal_negatif' => $solusiIdeal['negatif'],
            'hasil_akhir' => $hasilAkhir,
            'bobot_prioritas' => BobotPrioritasModel::all()->keyBy('bobot_id')
        ]);
    }

    private function buildMatriksKeputusan($laporans)
    {
        $kriteria = KriteriaModel::all()->pluck('kriteria_kode')->map(fn($kode) => strtolower($kode))->toArray();
        $matriks = [];
        foreach ($laporans as $lap) {
            if (!$lap instanceof LaporanModel) {
                Log::error('Invalid laporan type in buildMatriksKeputusan', [
                    'type' => gettype($lap),
                    'value' => is_array($lap) ? json_encode($lap) : $lap
                ]);
                continue;
            }
            $skor = TopsisService::hitungSkorPrioritas($lap);
            $nilai = $skor['nilai_kriteria'] ?? array_fill_keys($kriteria, 0);
            $matriks[] = array_merge([
                'laporan_id' => $lap->laporan_id,
                'judul' => $lap->judul
            ], $nilai);
        }
        return $matriks;
    }

    private function buildMatriksNormalisasi($matriksKeputusan)
    {
        $kriteria = KriteriaModel::all();
        $normalized = [];

        foreach ($kriteria as $k) {
            $kode = strtolower($k->kriteria_kode);
            $kolom = array_column($matriksKeputusan, $kode);
            $sumSquares = sqrt(array_sum(array_map(fn($x) => $x * $x, $kolom)));
            if ($sumSquares == 0) {
                Log::warning("Sum of squares is zero for criteria $kode");
                foreach ($matriksKeputusan as $i => $row) {
                    $normalized[$i][$kode] = 0;
                }
                continue;
            }
            foreach ($matriksKeputusan as $i => $row) {
                $normalized[$i][$kode] = $row[$kode] / $sumSquares;
            }
        }

        return $normalized;
    }

    private function buildMatriksTerbobot($matriksNormalisasi)
    {
        $kriteria = KriteriaModel::all();
        $terbobot = [];

        foreach ($matriksNormalisasi as $i => $row) {
            $terbobot[$i] = [];
            foreach ($kriteria as $k) {
                $kode = strtolower($k->kriteria_kode);
                $terbobot[$i][$kode] = $row[$kode] * $k->bobot;
            }
        }

        return $terbobot;
    }

    private function buildSolusiIdeal($matriksTerbobot)
    {
        $kriteria = KriteriaModel::all();
        $positif = [];
        $negatif = [];

        if (empty($matriksTerbobot)) {
            Log::warning('Empty matriksTerbobot in buildSolusiIdeal');
            foreach ($kriteria as $k) {
                $kode = strtolower($k->kriteria_kode);
                $positif[$kode] = 0;
                $negatif[$kode] = 0;
            }
            return ['positif' => $positif, 'negatif' => $negatif];
        }

        foreach ($kriteria as $k) {
            $kode = strtolower($k->kriteria_kode);
            $kolom = array_column($matriksTerbobot, $kode);
            if (empty($kolom)) {
                Log::warning("Empty column for criteria $kode in buildSolusiIdeal");
                $positif[$kode] = 0;
                $negatif[$kode] = 0;
                continue;
            }
            $positif[$kode] = $k->kriteria_jenis == 'benefit' ? max($kolom) : min($kolom);
            $negatif[$kode] = $k->kriteria_jenis == 'benefit' ? min($kolom) : max($kolom);
        }

        return ['positif' => $positif, 'negatif' => $negatif];
    }

    private function buildHasilAkhir($matriksTerbobot, $solusiIdealPositif, $solusiIdealNegatif, $matriksKeputusan)
    {
        $hasil = [];
        if (empty($matriksTerbobot) || empty($matriksKeputusan)) {
            Log::warning('Empty matriksTerbobot or matriksKeputusan in buildHasilAkhir', [
                'matriksTerbobot_count' => count($matriksTerbobot),
                'matriksKeputusan_count' => count($matriksKeputusan)
            ]);
            return $hasil;
        }

        foreach ($matriksTerbobot as $i => $row) {
            $jarakPositif = 0;
            $jarakNegatif = 0;
            foreach ($row as $kode => $nilai) {
                $jarakPositif += pow($nilai - $solusiIdealPositif[$kode], 2);
                $jarakNegatif += pow($nilai - $solusiIdealNegatif[$kode], 2);
            }
            $jarakPositif = sqrt($jarakPositif);
            $jarakNegatif = sqrt($jarakNegatif);
            $skor = ($jarakPositif + $jarakNegatif) != 0 ? $jarakNegatif / ($jarakPositif + $jarakNegatif) : 0;

            $hasil[] = [
                'laporan_id' => $matriksKeputusan[$i]['laporan_id'],
                'judul' => $matriksKeputusan[$i]['judul'],
                'jarak_positif' => $jarakPositif,
                'jarak_negatif' => $jarakNegatif,
                'skor_akhir' => $skor
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
