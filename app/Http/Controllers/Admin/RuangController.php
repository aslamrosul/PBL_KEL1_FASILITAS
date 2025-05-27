<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RuangModel;
use App\Models\LantaiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RuangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Ruang',
            'list' => ['Home', 'Ruang']
        ];

        $page = (object) [
            'title' => 'Daftar ruang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'ruang';

        return view('admin.ruang.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $ruangs = RuangModel::with('lantai.gedung')->select('ruang_id', 'lantai_id', 'ruang_kode', 'ruang_nama');

        return DataTables::of($ruangs)
            ->addIndexColumn()
            ->addColumn('lantai_info', function ($ruang) {
                $lantai = $ruang->lantai;
                $gedung = $lantai->gedung ?? null;
                return $gedung ? $gedung->gedung_nama . ' - Lantai ' . $lantai->lantai_nomor : 'Lantai ' . $lantai->lantai_nomor;
            })
            ->addColumn('aksi', function ($ruang) {
                $showUrl = url('/ruang/' . $ruang->ruang_id . '/show_ajax');
                $editUrl = url('/ruang/' . $ruang->ruang_id . '/edit_ajax');
                $deleteUrl = url('/ruang/' . $ruang->ruang_id . '/delete_ajax');

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

    public function create_ajax()
    {
        $lantais = LantaiModel::with('gedung')->get();
        return view('admin.ruang.create_ajax', compact('lantais'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lantai_id' => 'required|integer|exists:m_lantai,lantai_id',
            'ruang_kode' => 'required|string|max:10|unique:m_ruang,ruang_kode',
            'ruang_nama' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $ruang = RuangModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $ruang->ruang_id,
                'ruang_nama' => $ruang->ruang_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit_ajax($ruang_id)
    {
        $ruang = RuangModel::find($ruang_id);
        $lantais = LantaiModel::with('gedung')->get();
        return view('admin.ruang.edit_ajax', compact('ruang', 'lantais'));
    }

    public function update_ajax(Request $request, $ruang_id)
    {
        $validator = Validator::make($request->all(), [
            'lantai_id' => 'required|integer|exists:m_lantai,lantai_id',
            'ruang_kode' => 'required|string|max:10|unique:m_ruang,ruang_kode,'.$ruang_id.',ruang_id',
            'ruang_nama' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $ruang = RuangModel::find($ruang_id);
        if (!$ruang) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        try {
            $ruang->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $ruang->ruang_id,
                'ruang_nama' => $ruang->ruang_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function confirm_ajax($ruang_id)
    {
        $ruang = RuangModel::find($ruang_id);
        return view('admin.ruang.confirm_ajax', compact('ruang'));
    }

    public function delete_ajax($ruang_id)
    {
        $ruang = RuangModel::find($ruang_id);
        if ($ruang) {
            // Cek apakah ruang memiliki fasilitas terkait
            if ($ruang->fasilitas()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus ruang karena sudah memiliki fasilitas terkait.'
                ]);
            }

            $ruang->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Data Ruang tidak ditemukan.'
        ]);
    }

    public function show_ajax($ruang_id)
    {
        $ruang = RuangModel::with('lantai.gedung')->find($ruang_id);
        return view('admin.ruang.show_ajax', compact('ruang'));
    }

    public function import()
    {
        return view('admin.ruang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_ruang' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_ruang');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];
            $errors = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $lantai_id = trim($value['A']);
                        $ruang_kode = trim($value['B']);
                        $ruang_nama = trim($value['C']);

                        $insert[] = [
                            'lantai_id' => $lantai_id,
                            'ruang_kode' => $ruang_kode,
                            'ruang_nama' => $ruang_nama,
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    RuangModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => count($errors) === 0,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tidak ada data yang bisa diimport'
                ]);
            }
        }

        return redirect('/');
    }

    public function export_excel()
    {
        $ruangs = RuangModel::with('lantai.gedung')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Lokasi');
        $sheet->setCellValue('C1', 'Kode Ruang');
        $sheet->setCellValue('D1', 'Nama Ruang');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($ruangs as $ruang) {
            $lokasi = ($ruang->lantai->gedung->gedung_nama ?? '-') . ' - Lantai ' . $ruang->lantai->lantai_nomor;
            
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $lokasi);
            $sheet->setCellValue('C' . $baris, $ruang->ruang_kode);
            $sheet->setCellValue('D' . $baris, $ruang->ruang_nama);
            $no++;
            $baris++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Ruang');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Ruang_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $ruangs = RuangModel::with('lantai.gedung')->get();

        $data = [
            'ruangs' => $ruangs,
            'title' => 'Laporan Data Ruang'
        ];

        $pdf = Pdf::loadView('admin.ruang.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Ruang ' . date('Y-m-d H-i-s') . '.pdf');
    }
}