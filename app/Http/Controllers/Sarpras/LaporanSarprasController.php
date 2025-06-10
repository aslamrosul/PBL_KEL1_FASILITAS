<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\PeriodeModel;
use App\Models\FasilitasModel;
use App\Models\BobotPrioritasModel;
use App\Models\PerbaikanModel;
use App\Models\RiwayatPenugasanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $laporan = LaporanModel::with(['periode', 'fasilitas', 'bobotPrioritas', 'user'])
            ->select('t_laporan.*');

        // Filter berdasarkan periode
        if ($request->periode_id) {
            $laporan->where('periode_id', $request->periode_id);
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

        return DataTables::of($laporan)
        ->addIndexColumn()
        ->addColumn('aksi', function ($laporan) {
            $btn = '<button onclick="modalAction(\'' . url('/sarpras/laporan/' . $laporan->laporan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm me-1"><i class="fa fa-eye"></i></button>';

            // Tombol Assign (jika laporan diterima)
            if ($laporan->status == 'diterima') {
                $btn .= '<button onclick="modalAction(\'' . url('/sarpras/laporan/' . $laporan->laporan_id . '/assign_ajax') . '\')" class="btn btn-success btn-sm me-1">
                    <i class="fa fa-briefcase"></i>
                </button>';
            }

            // Tombol Ubah Status (jika status bukan 'selesai' atau 'ditolak')
           if (!in_array($laporan->status, ['diterima', 'ditolak'])) {
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

    /**
     * Memproses perubahan status laporan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id laporan_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_status(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:diterima,ditolak', // Sesuaikan dengan status yang valid
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $laporan = LaporanModel::find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Laporan tidak ditemukan.'
                ], 404);
            }

            $laporan->status = $request->status;
            $laporan->save();

            return response()->json([
                'status' => true,
                'message' => 'Status laporan berhasil diperbarui.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui status laporan: ' . $e->getMessage()
            ]);
        }
    }

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
