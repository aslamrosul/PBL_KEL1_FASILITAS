<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\PeriodeModel;
use App\Models\FasilitasModel;
use App\Models\BobotPrioritasModel;
use App\Models\KriteriaModel;
use App\Models\PerbaikanModel;
use App\Models\RekomendasiModel;
use App\Models\RiwayatPenugasanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LaporanSarprasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Laporan',
            'list' => ['Home', 'Laporan']
        ];

        $page = (object) [
            'title' => 'Daftar laporan kerusakan yang perlu ditangani'
        ];

        $activeMenu = 'laporan';
        $periodes = PeriodeModel::all();
        $fasilitas = FasilitasModel::all();
        $prioritas = BobotPrioritasModel::all();

        return view('sarpras.laporan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'periodes' => $periodes,
            'fasilitas' => $fasilitas,
            'prioritas' => $prioritas,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $laporan = LaporanModel::with(['user', 'fasilitas', 'bobotPrioritas', 'user'])
            ->select('t_laporan.*');

        // Filter berdasarkan periode
        if ($request->user_Id) {
            $laporan->where('user_id', $request->user_id);
        }

        // Filter berdasarkan fasilitas
        if ($request->fasilitas_id) {
            $laporan->where('fasilitas_id', $request->fasilitas_id);
        }

        // Filter berdasarkan status
        if ($request->status) {
            $laporan->where('status', $request->status);
        }

        // Filter berdasarkan prioritas
        if ($request->bobot_id) {
            $laporan->where('bobot_id', $request->bobot_id);
        }
        $laporan->where('status', '!=', 'diterima');

        return DataTables::of($laporan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($laporan) {
                $btn = '<button onclick="modalAction(\'' . url('/sarpras/laporan/' . $laporan->laporan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm me-1"><i class="fa fa-eye"></i></button>';



                // Tombol Ubah Status (jika status bukan 'selesai' atau 'ditolak')
                if (!in_array($laporan->status, ['diterima', 'ditolak', 'selesai'])) {
                    $btn .= '<button onclick="modalAction(\'' . url('/sarpras/laporan/' . $laporan->laporan_id . '/change_status_ajax') . '\')" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i>
                </button>';
                }

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax($id)
    {
        $laporan = LaporanModel::with(['periode', 'fasilitas', 'bobotPrioritas', 'user'])->find($id);
        return view('sarpras.laporan.show_ajax', compact('laporan'));
    }


    public function export_excel()
    {
        $laporan = LaporanModel::with(['periode', 'fasilitas', 'bobotPrioritas', 'user'])
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Judul');
        $sheet->setCellValue('C1', 'Deskripsi');
        $sheet->setCellValue('D1', 'Pelapor');
        $sheet->setCellValue('E1', 'Periode');
        $sheet->setCellValue('F1', 'Fasilitas');
        $sheet->setCellValue('G1', 'Prioritas');
        $sheet->setCellValue('H1', 'Status');
        $sheet->setCellValue('I1', 'Tanggal Lapor');

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($laporan as $item) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $item->judul);
            $sheet->setCellValue('C' . $baris, $item->deskripsi);
            $sheet->setCellValue('D' . $baris, $item->user->nama ?? '-');
            $sheet->setCellValue('E' . $baris, $item->periode->periode_nama ?? '-');
            $sheet->setCellValue('F' . $baris, $item->fasilitas->fasilitas_nama ?? '-');
            $sheet->setCellValue('G' . $baris, $item->bobotPrioritas->bobot_nama ?? '-');
            $sheet->setCellValue('H' . $baris, $item->status);
            $sheet->setCellValue('I' . $baris, $item->created_at->format('d-m-Y'));
            $no++;
            $baris++;
        }

        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Laporan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Laporan_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $laporan = LaporanModel::with(['periode', 'fasilitas', 'bobotPrioritas', 'user'])
            ->get();

        $data = [
            'laporan' => $laporan,
            'title' => 'Laporan Data Kerusakan'
        ];

        $pdf = Pdf::loadView('sarpras.laporan.export_pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Laporan ' . date('Y-m-d H-i-s') . '.pdf');
    }

    public function change_status_ajax($id)
    {
        $laporan = LaporanModel::find($id);
        if (!$laporan) {
            return response()->json(['error' => 'Laporan tidak ditemukan.'], 404);
        }
        return view('sarpras.laporan.change_status_ajax', compact('laporan'));
    }


    // /**
    //  * Memproses perubahan status laporan.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id laporan_id
    //  * @return \Illuminate\Http\JsonResponse
    //  */

    private function hitungFrekuensiLaporan($fasilitasId)
    {
        return LaporanModel::where('fasilitas_id', $fasilitasId)->count();
    }

    private function hitungUsiaFasilitas($tahunPengadaan)
    {
        return now()->year - $tahunPengadaan;
    }

    private function hitungKondisiFasilitas($status)
    {
        return ['rusak berat' => 3, 'rusak sedang' => 2, 'rusak ringan' => 1, 'baik' => 1 ][$status] ?? 0;
    }

    private function tentukanBobotPrioritas($skor)
    {
        if ($skor >= 0.7) return 1; // Tinggi
        if ($skor >= 0.4) return 2; // Sedang
        return 3; // Rendah
    }

   private function hitungSkorPrioritas($laporan)
{
    $kriteria = KriteriaModel::all();
    $fasilitas = $laporan->fasilitas;

    if (!$fasilitas || !$fasilitas->barang || !$fasilitas->barang->klasifikasi) {
        Log::error('Fasilitas atau data terkait tidak lengkap untuk laporan_id: ' . $laporan->laporan_id);
        return [
            'nilai_kriteria' => [
                'frekuensi' => 0,
                'usia' => 0,
                'kondisi' => 0,
                'barang' => 0,
                'klasifikasi' => 0
            ],
            'skor_total' => 0,
            'max_values' => []
        ];
    }

    // Ambil laporan lain dalam periode yang sama
    $batchLaporans = LaporanModel::with(['fasilitas.barang.klasifikasi'])
        ->where('periode_id', $laporan->periode_id)
        ->where('status', 'diterima')
        ->get();

    if ($batchLaporans->isEmpty()) {
        Log::warning('Tidak ada laporan lain dalam periode untuk laporan_id: ' . $laporan->laporan_id);
        return [
            'nilai_kriteria' => [
                'frekuensi' => 0,
                'usia' => 0,
                'kondisi' => 0,
                'barang' => 0,
                'klasifikasi' => 0
            ],
            'skor_total' => 0,
            'max_values' => []
        ];
    }

    // Bangun matriks keputusan
    $matriks = [];
    foreach ($batchLaporans as $lap) {
        $nilaiKriteria = [
            'frekuensi' => $this->hitungFrekuensiLaporan($lap->fasilitas->fasilitas_id),
            'usia' => $this->hitungUsiaFasilitas($lap->fasilitas->tahun_pengadaan),
            'kondisi' => $this->hitungKondisiFasilitas($lap->fasilitas->status),
            'barang' => (float)($lap->fasilitas->barang->bobot_prioritas ?? 0),
            'klasifikasi' => (float)($lap->fasilitas->barang->klasifikasi->bobot_prioritas ?? 0)
        ];
        $matriks[] = array_merge(['laporan_id' => $lap->laporan_id], $nilaiKriteria);
    }

    // Normalisasi (TOPSIS)
    $normalized = [];
    foreach ($kriteria as $k) {
        $kode = strtolower($k->kriteria_kode);
        $kolom = array_column($matriks, $kode);
        $sumSquares = sqrt(array_sum(array_map(fn($x) => $x * $x, $kolom)));

        if ($sumSquares == 0) {
            Log::warning("Sum of squares is zero for criteria $kode in periode_id: {$laporan->periode_id}", [
                'kolom' => $kolom
            ]);
            foreach ($matriks as $i => $row) {
                $normalized[$i][$kode] = 0;
            }
            continue;
        }

        foreach ($matriks as $i => $row) {
            $normalized[$i][$kode] = $row[$kode] / $sumSquares;
        }
    }

    // Matriks terbobot
    $terbobot = [];
    foreach ($normalized as $i => $row) {
        foreach ($kriteria as $k) {
            $kode = strtolower($k->kriteria_kode);
            $terbobot[$i][$kode] = $row[$kode] * $k->bobot;
        }
    }

    // Solusi ideal
    $positif = [];
    $negatif = [];
    foreach ($kriteria as $k) {
        $kode = strtolower($k->kriteria_kode);
        $kolom = array_column($terbobot, $kode);
        $positif[$kode] = $k->kriteria_jenis == 'benefit' ? max($kolom) : min($kolom);
        $negatif[$kode] = $k->kriteria_jenis == 'benefit' ? min($kolom) : max($kolom);
    }

    // Hitung skor TOPSIS
    foreach ($terbobot as $i => $row) {
        $jarakPositif = 0;
        $jarakNegatif = 0;

        foreach ($row as $kode => $nilai) {
            $jarakPositif += pow($nilai - $positif[$kode], 2);
            $jarakNegatif += pow($nilai - $negatif[$kode], 2);
        }

        $jarakPositif = sqrt($jarakPositif);
        $jarakNegatif = sqrt($jarakNegatif);
        $skor = ($jarakPositif + $jarakNegatif) != 0 ? $jarakNegatif / ($jarakPositif + $jarakNegatif) : 0;

        if ($matriks[$i]['laporan_id'] == $laporan->laporan_id) {
            return [
                'nilai_kriteria' => [
                    'frekuensi' => $normalized[$i]['frekuensi'] ?? 0,
                    'usia' => $normalized[$i]['usia'] ?? 0,
                    'kondisi' => $normalized[$i]['kondisi'] ?? 0,
                    'barang' => $normalized[$i]['barang'] ?? 0,
                    'klasifikasi' => $normalized[$i]['klasifikasi'] ?? 0
                ],
                'skor_total' => $skor,
                'max_values' => []
            ];
        }
    }

    return [
        'nilai_kriteria' => [
            'frekuensi' => 0,
            'usia' => 0,
            'kondisi' => 0,
            'barang' => 0,
            'klasifikasi' => 0
        ],
        'skor_total' => 0,
        'max_values' => []
    ];
}

    public function changeStatus($id)
    {
        $laporan = LaporanModel::find($id);

        if (!$laporan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make(request()->all(), [
            'status' => 'required|in:diterima,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'status' => request()->status,
            'alasan_penolakan' => request()->alasan_penolakan
        ];

        if (request()->status == 'diterima') {
            try {
                $skor = $this->hitungSkorPrioritas($laporan);
                $bobotId = $this->tentukanBobotPrioritas($skor['skor_total']);

                if (!$bobotId) {
                    throw new \Exception("Tidak dapat menentukan bobot prioritas");
                }

                $data['bobot_id'] = $bobotId;

                $nilaiKriteria = $skor['nilai_kriteria'] ?? [
                    'frekuensi' => 0,
                    'usia' => 0,
                    'kondisi' => 0,
                    'barang' => 0,
                    'klasifikasi' => 0
                ];
                $skorTotal = $skor['skor_total'] ?? 0;

                $jsonKriteria = json_encode($nilaiKriteria);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('JSON encoding failed for nilai_kriteria', [
                        'nilai_kriteria' => $nilaiKriteria,
                        'error' => json_last_error_msg()
                    ]);
                    throw new \Exception('Gagal mengencode nilai_kriteria: ' . json_last_error_msg());
                }

                Log::info('Data to be saved for laporan_id: ' . $laporan->laporan_id, [
                    'nilai_kriteria' => $nilaiKriteria,
                    'skor_total' => $skorTotal,
                    'bobot_id' => $bobotId
                ]);

                $rekomendasi = RekomendasiModel::updateOrCreate(
                    ['laporan_id' => $laporan->laporan_id],
                    [
                        'nilai_kriteria' => $jsonKriteria,
                        'skor_total' => $skorTotal,
                        'bobot_id' => $bobotId
                    ]
                );

                Log::info('Rekomendasi saved for laporan_id: ' . $laporan->laporan_id, [
                    'rekomendasi_id' => $rekomendasi->rekomendasi_id,
                    'nilai_kriteria' => $rekomendasi->nilai_kriteria,
                    'skor_total' => $rekomendasi->skor_total,
                    'bobot_id' => $rekomendasi->bobot_id
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menghitung skor prioritas untuk laporan_id: ' . $laporan->laporan_id, [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghitung skor prioritas: ' . $e->getMessage()
                ], 500);
            }
        }

        $laporan->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Status laporan berhasil diupdate'
        ], 200);
    }

    public function recalculateRecommendations(Request $request, $level_id = null)
    {
        try {
            $laporans = LaporanModel::with(['fasilitas', 'fasilitas.barang', 'fasilitas.barang.klasifikasi'])
                ->where('status', 'diterima')
                ->when($level_id, function ($query, $level_id) {
                    $query->whereHas('user', function ($q) use ($level_id) {
                        $q->where('level_id', $level_id);
                    });
                })
                ->get();

            if ($laporans->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada laporan dengan status diterima untuk dihitung ulang'
                ], 404);
            }

            $results = [];
            foreach ($laporans as $laporan) {
                $skor = $this->hitungSkorPrioritas($laporan);
                $bobotId = $this->tentukanBobotPrioritas($skor['skor_total']);

                $nilaiKriteria = $skor['nilai_kriteria'] ?? [
                    'frekuensi' => 0,
                    'usia' => 0,
                    'kondisi' => 0,
                    'barang' => 0,
                    'klasifikasi' => 0
                ];
                $skorTotal = $skor['skor_total'] ?? 0;

                $jsonKriteria = json_encode($nilaiKriteria);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('JSON encoding failed for nilai_kriteria', [
                        'nilai_kriteria' => $nilaiKriteria,
                        'error' => json_last_error_msg()
                    ]);
                    throw new \Exception('Gagal mengencode nilai_kriteria: ' . json_last_error_msg());
                }

                Log::info('Data to be saved for laporan_id: ' . $laporan->laporan_id, [
                    'nilai_kriteria' => $nilaiKriteria,
                    'skor_total' => $skorTotal,
                    'bobot_id' => $bobotId
                ]);

                $rekomendasi = RekomendasiModel::updateOrCreate(
                    ['laporan_id' => $laporan->laporan_id],
                    [
                        'nilai_kriteria' => $jsonKriteria,
                        'skor_total' => $skorTotal,
                        'bobot_id' => $bobotId
                    ]
                );

                Log::info('Rekomendasi saved for laporan_id: ' . $laporan->laporan_id, [
                    'rekomendasi_id' => $rekomendasi->rekomendasi_id,
                    'nilai_kriteria' => $rekomendasi->nilai_kriteria,
                    'skor_total' => $rekomendasi->skor_total,
                    'bobot_id' => $rekomendasi->bobot_id
                ]);

                $laporan->update(['bobot_id' => $bobotId]);

                $results[] = [
                    'laporan_id' => $laporan->laporan_id,
                    'skor_total' => $skorTotal,
                    'prioritas' => BobotPrioritasModel::find($bobotId)->bobot_nama ?? 'Tidak diketahui'
                ];
            }

            return response()->json([
                'status' => true,
                'message' => 'Rekomendasi berhasil dihitung ulang',
                'data' => $results
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal menghitung ulang rekomendasi', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghitung ulang rekomendasi: ' . $e->getMessage()
            ], 500);
        }
    }
    // Fungsi-fungsi helper sama seperti di RekomendasiController
    public function assign_ajax($id)
    {
        $laporan = LaporanModel::find($id);
        $teknisi = UserModel::whereHas('level', function ($query) {
            $query->where('level_kode', 'TKN'); // Atau pakai where('level_id', 3) jika pakai angka
        })->get();
        return view('sarpras.laporan.assign_ajax', compact('laporan', 'teknisi'));
    }

    public function assign(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'teknisi_id' => 'required|exists:m_user,user_id',
            'catatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            // Buat perbaikan baru
            $perbaikan = PerbaikanModel::create([
                'laporan_id' => $id,
                'teknisi_id' => $request->teknisi_id,
                'tanggal_mulai' => now(),
                'status' => 'dalam_antrian',
                'catatan' => $request->catatan
            ]);

            // Update status laporan
            LaporanModel::find($id)->update(['status' => 'diproses']);

            // Buat riwayat penugasan
            RiwayatPenugasanModel::create([
                'laporan_id' => $id,
                'teknisi_id' => $request->teknisi_id,
                'sarpras_id' => auth()->user()->user_id, // Assuming authenticated user is sarpras
                'tanggal_penugasan' => now(),
                'status_penugasan' => 'ditugaskan',
                'catatan' => $request->catatan
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Teknisi berhasil ditugaskan',
                'id' => $perbaikan->perbaikan_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menugaskan teknisi: ' . $e->getMessage()
            ]);
        }
    }
}
