<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LantaiModel;
use App\Models\GedungModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LantaiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Lantai',
            'list' => ['Home', 'Lantai']
        ];

        $page = (object) [
            'title' => 'Daftar lantai yang terdaftar dalam sistem'
        ];

        $activeMenu = 'lantai';

        return view('admin.lantai.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $lantais = LantaiModel::with('gedung')->select('lantai_id', 'gedung_id', 'lantai_nomor');

        return DataTables::of($lantais)
            ->addIndexColumn()
            ->addColumn('gedung_nama', function ($lantai) {
                return $lantai->gedung->gedung_nama ?? '-';
            })
            ->addColumn('aksi', function ($lantai) {
                $showUrl = secure_url('/lantai/' . $lantai->lantai_id . '/show_ajax');
                $editUrl = secure_url('/lantai/' . $lantai->lantai_id . '/edit_ajax');
                $deleteUrl = secure_url('/lantai/' . $lantai->lantai_id . '/delete_ajax');

                return '
                     <button onclick="modalAction(\'' . $showUrl . '\')" class="btn btn-info btn-sm" title="Lihat Periode">
                        <i class="fa fa-eye"></i>  
                    </button>
                    <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-warning btn-sm" title="Edit Periode">
                        <i class="fa fa-edit"></i>  
                    </button>
                    <button onclick="modalAction(\'' . $deleteUrl . '\')" class="btn btn-danger btn-sm" title="Hapus Periode">
                        <i class="fa fa-trash"></i>  
                    </button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $gedungs = GedungModel::all();
        return view('admin.lantai.create_ajax', compact('gedungs'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gedung_id' => 'required|integer|exists:m_gedung,gedung_id',
            'lantai_nomor' => 'required|string|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $lantai = LantaiModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $lantai->lantai_id,
                'lantai_nomor' => $lantai->lantai_nomor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit_ajax($lantai_id)
    {
        $lantai = LantaiModel::find($lantai_id);
        $gedungs = GedungModel::all();
        return view('admin.lantai.edit_ajax', compact('lantai', 'gedungs'));
    }

    public function update_ajax(Request $request, $lantai_id)
    {
        $validator = Validator::make($request->all(), [
            'gedung_id' => 'required|integer|exists:m_gedung,gedung_id',
            'lantai_nomor' => 'required|string|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $lantai = LantaiModel::find($lantai_id);
        if (!$lantai) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        try {
            $lantai->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $lantai->lantai_id,
                'lantai_nomor' => $lantai->lantai_nomor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function confirm_ajax($lantai_id)
    {
        $lantai = LantaiModel::find($lantai_id);
        return view('admin.lantai.confirm_ajax', compact('lantai'));
    }

    public function delete_ajax($lantai_id)
    {
        $lantai = LantaiModel::find($lantai_id);
        if ($lantai) {
            // Cek apakah lantai memiliki ruang terkait
            if ($lantai->ruangs()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus lantai karena sudah memiliki ruang terkait.'
                ]);
            }

            $lantai->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Data Lantai tidak ditemukan.'
        ]);
    }

    public function show_ajax($lantai_id)
    {
        $lantai = LantaiModel::with('gedung')->find($lantai_id);
        return view('admin.lantai.show_ajax', compact('lantai'));
    }

    public function import()
    {
        return view('admin.lantai.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_lantai' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_lantai');
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
                        $gedung_id = trim($value['A']);
                        $lantai_nomor = trim($value['B']);

                        $insert[] = [
                            'gedung_id' => $gedung_id,
                            'lantai_nomor' => $lantai_nomor,
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    LantaiModel::insertOrIgnore($insert);
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
        $lantais = LantaiModel::with('gedung')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Gedung');
        $sheet->setCellValue('C1', 'Nomor Lantai');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($lantais as $lantai) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $lantai->gedung->gedung_nama ?? '-');
            $sheet->setCellValue('C' . $baris, $lantai->lantai_nomor);
            $no++;
            $baris++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Lantai');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Lantai_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        $lantais = LantaiModel::with('gedung')->get();

        $data = [
            'lantais' => $lantais,
            'title' => 'Laporan Data Lantai'
        ];

        $pdf = Pdf::loadView('admin.lantai.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Lantai ' . date('Y-m-d H-i-s') . '.pdf');
    }
}