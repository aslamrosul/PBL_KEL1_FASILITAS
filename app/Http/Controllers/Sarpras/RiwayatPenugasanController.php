<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPenugasanModel;
use App\Models\LaporanModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RiwayatPenugasanController extends Controller
{
    // Menampilkan daftar riwayat penugasan
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Riwayat Penugasan',
            'list' => ['Home', 'Riwayat Penugasan']
        ];
        $page = (object) [
            'title' => 'Daftar riwayat penugasan yang terdaftar'
        ];
        $activeMenu = 'riwayat_penugasan';
        return view('admin.riwayat_penugasan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Mengambil data untuk DataTable
    public function list(Request $request)
    {
        $riwayat = RiwayatPenugasanModel::with(['laporan', 'teknisi', 'sarpras'])->select('riwayat_penugasan_id', 'laporan_id', 'teknisi_id', 'sarpras_id', 'tanggal_penugasan', 'status_penugasan');
        
        return DataTables::of($riwayat)
            ->addIndexColumn()
            ->addColumn('laporan_judul', function ($item) {
                return $item->laporan->judul ?? '-';
            })
            ->addColumn('teknisi_nama', function ($item) {
                return $item->teknisi->nama ?? '-';
            })
            ->addColumn('sarpras_nama', function ($item) {
                return $item->sarpras->nama ?? '-';
            })
            ->addColumn('aksi', function ($item) {
                $showUrl = url('/riwayat_penugasan/' . $item->riwayat_penugasan_id . '/show_ajax');
                $editUrl = url('/riwayat_penugasan/' . $item->riwayat_penugasan_id . '/edit_ajax');
                $deleteUrl = url('/riwayat_penugasan/' . $item->riwayat_penugasan_id . '/delete_ajax');
                return '
                    <button onclick="modalAction(\'' . $showUrl . '\')" class="btn btn-info btn-sm" title="Lihat">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-warning btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button onclick="modalAction(\'' . $deleteUrl . '\')" class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan form tambah data
    public function create_ajax()
    {
        $laporan = LaporanModel::all();
        $teknisi = UserModel::whereHas('level', function ($query) {
            $query->where('level_kode', 'TKN'); // Filter teknisi
        })->get();
        $sarpras = UserModel::whereHas('level', function ($query) {
            $query->where('level_kode', 'SPR'); // Filter petugas sarpras
        })->get();
        return view('admin.riwayat_penugasan.create_ajax', compact('laporan', 'teknisi', 'sarpras'));
    }

    // Menyimpan data baru
    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'laporan_id' => 'required|exists:t_laporan,laporan_id',
            'teknisi_id' => 'required|exists:m_user,user_id',
            'sarpras_id' => 'required|exists:m_user,user_id',
            'tanggal_penugasan' => 'required|date',
            'status_penugasan' => 'required|in:ditugaskan,selesai,dibatalkan',
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
            $riwayat = RiwayatPenugasanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $riwayat->riwayat_penugasan_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    // Export ke Excel
    public function export_excel()
    {
        $riwayat = RiwayatPenugasanModel::with(['laporan', 'teknisi', 'sarpras'])->get();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Laporan');
        $sheet->setCellValue('C1', 'Teknisi');
        $sheet->setCellValue('D1', 'Petugas Sarpras');
        $sheet->setCellValue('E1', 'Tanggal Penugasan');
        $sheet->setCellValue('F1', 'Status');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($riwayat as $item) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $item->laporan->judul ?? '-');
            $sheet->setCellValue('C' . $baris, $item->teknisi->nama ?? '-');
            $sheet->setCellValue('D' . $baris, $item->sarpras->nama ?? '-');
            $sheet->setCellValue('E' . $baris, $item->tanggal_penugasan);
            $sheet->setCellValue('F' . $baris, $item->status_penugasan);
            $no++;
            $baris++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Riwayat Penugasan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Riwayat_Penugasan_' . date('Y-m-d_H-i-s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }

    // Export ke PDF
    public function export_pdf()
    {
        $riwayat = RiwayatPenugasanModel::with(['laporan', 'teknisi', 'sarpras'])->get();
        $data = [
            'riwayat' => $riwayat,
            'title' => 'Laporan Riwayat Penugasan'
        ];
        $pdf = Pdf::loadView('admin.riwayat_penugasan.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        return $pdf->stream('Riwayat_Penugasan_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}