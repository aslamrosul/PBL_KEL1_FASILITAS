<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\PeriodeModel;
use App\Models\FasilitasModel;
use App\Models\BobotPrioritasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class LaporanPelaporController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Laporan',
            'list' => ['Home', 'Laporan']
        ];

        $page = (object) [
            'title' => 'Daftar laporan yang dibuat oleh pelapor'
        ];

        $activeMenu = 'laporan';

        return view('pelapor.laporan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $laporan = LaporanModel::where('user_id', Auth::id())
                ->with(['periode', 'fasilitas', 'bobotPrioritas'])
                ->select('t_laporan.*');

            return DataTables::of($laporan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($laporan) {
                    $showUrl = url('/pelapor/laporan/' . $laporan->laporan_id . '/show_ajax');
                    $editUrl = url('/pelapor/laporan/' . $laporan->laporan_id . '/edit_ajax');
                    $deleteUrl = url('/pelapor/laporan/' . $laporan->laporan_id . '/confirm_ajax');

                    return '
                        <button onclick="modalAction(\'' . $showUrl . '\')" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> Detail
                        </button>
                        <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button onclick="modalAction(\'' . $deleteUrl . '\')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function create_ajax()
    {
        $periode = PeriodeModel::select('periode_id', 'nama_periode')->get();
        $fasilitas = FasilitasModel::select('fasilitas_id', 'nama_fasilitas')->get();
        $bobot = BobotPrioritasModel::select('bobot_id', 'nama_bobot')->get();
        return view('pelapor.laporan.create_ajax', compact('periode', 'fasilitas', 'bobot'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:100',
                'deskripsi' => 'required|string',
                'periode_id' => 'required|exists:m_periode,periode_id',
                'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id',
                'bobot_id' => 'nullable|exists:m_bobot_prioritas,bobot_id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $data = [
                    'user_id' => Auth::id(),
                    'periode_id' => $request->periode_id,
                    'fasilitas_id' => $request->fasilitas_id,
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'bobot_id' => $request->bobot_id,
                    'status' => 'pending',
                ];

                if ($request->hasFile('foto')) {
                    $data['foto_path'] = $request->file('foto')->store('laporan_fotos', 'public');
                }

                $laporan = LaporanModel::create($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Laporan berhasil ditambahkan',
                    'id' => $laporan->laporan_id,
                    'judul' => $laporan->judul
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menambah laporan: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function edit_ajax($id)
    {
        $laporan = LaporanModel::find($id);
        if (!$laporan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        $periode = PeriodeModel::select('periode_id', 'nama_periode')->get();
        $fasilitas = FasilitasModel::select('fasilitas_id', 'nama_fasilitas')->get();
        $bobot = BobotPrioritasModel::select('bobot_id', 'nama_bobot')->get();
        return view('pelapor.laporan.edit_ajax', compact('laporan', 'periode', 'fasilitas', 'bobot'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:100',
                'deskripsi' => 'required|string',
                'periode_id' => 'required|exists:m_periode,periode_id',
                'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id',
                'bobot_id' => 'nullable|exists:m_bobot_prioritas,bobot_id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $laporan = LaporanModel::find($id);
            if (!$laporan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            try {
                $data = [
                    'periode_id' => $request->periode_id,
                    'fasilitas_id' => $request->fasilitas_id,
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'bobot_id' => $request->bobot_id,
                ];

                if ($request->hasFile('foto')) {
                    if ($laporan->foto_path) {
                        Storage::disk('public')->delete($laporan->foto_path);
                    }
                    $data['foto_path'] = $request->file('foto')->store('laporan_fotos', 'public');
                }

                $laporan->update($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Laporan berhasil diupdate',
                    'id' => $laporan->laporan_id,
                    'judul' => $laporan->judul
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengupdate laporan: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function confirm_ajax($id)
    {
        $laporan = LaporanModel::find($id);
        if (!$laporan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return view('pelapor.laporan.confirm_ajax', compact('laporan'));
    }

    public function delete_ajax($id)
    {
        if (request()->ajax()) {
            $laporan = LaporanModel::find($id);
            if ($laporan) {
                if ($laporan->foto_path) {
                    Storage::disk('public')->delete($laporan->foto_path);
                }
                $laporan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Laporan berhasil dihapus'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function show_ajax($id)
    {
        $laporan = LaporanModel::with(['periode', 'fasilitas', 'bobotPrioritas', 'user'])->find($id);
        if (!$laporan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return view('pelapor.laporan.show_ajax', compact('laporan'));
    }

    public function import()
    {
        return view('pelapor.laporan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_laporan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_laporan');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'user_id' => Auth::id(),
                            'periode_id' => trim($value['A']),
                            'fasilitas_id' => trim($value['B']),
                            'judul' => trim($value['C']),
                            'deskripsi' => trim($value['D']),
                            'bobot_id' => trim($value['E']) ?: null,
                            'status' => 'pending',
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    LaporanModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data laporan berhasil diimport'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang bisa diimport'
            ]);
        }

        return redirect('/');
    }

    public function export_excel()
    {
        $laporan = LaporanModel::where('user_id', Auth::id())
            ->with(['periode', 'fasilitas', 'bobotPrioritas'])
            ->select('t_laporan.*')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Judul');
        $sheet->setCellValue('C1', 'Deskripsi');
        $sheet->setCellValue('D1', 'Periode');
        $sheet->setCellValue('E1', 'Fasilitas');
        $sheet->setCellValue('F1', 'Prioritas');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Tanggal Lapor');
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($laporan as $item) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $item->judul);
            $sheet->setCellValue('C' . $baris, $item->deskripsi);
            $sheet->setCellValue('D' . $baris, $item->periode->nama_periode ?? '-');
            $sheet->setCellValue('E' . $baris, $item->fasilitas->nama_fasilitas ?? '-');
            $sheet->setCellValue('F' . $baris, $item->bobotPrioritas->nama_bobot ?? '-');
            $sheet->setCellValue('G' . $baris, $item->status);
            $sheet->setCellValue('H' . $baris, $item->tanggal_lapor);
            $no++;
            $baris++;
        }

        foreach (range('A', 'H') as $columnID) {
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
        $laporan = LaporanModel::where('user_id', Auth::id())
            ->with(['periode', 'fasilitas', 'bobotPrioritas'])
            ->select('t_laporan.*')
            ->get();

        $data = [
            'laporan' => $laporan,
            'title' => 'Laporan Data Pelapor'
        ];

        $pdf = Pdf::loadView('pelapor.laporan.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Laporan ' . date('Y-m-d H-i-s') . '.pdf');
    }
}