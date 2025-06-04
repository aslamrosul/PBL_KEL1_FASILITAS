<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GedungModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GedungController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Gedung',
            'list' => ['Home', 'Gedung']
        ];

        $page = (object) [
            'title' => 'Daftar gedung yang terdaftar dalam sistem'
        ];

        $activeMenu = 'gedung';

        return view('admin.gedung.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $gedungs = GedungModel::select('gedung_id', 'gedung_kode', 'gedung_nama');

        return DataTables::of($gedungs)
            ->addIndexColumn()
            ->addColumn('aksi', function ($gedung) {
                $showUrl = url('/gedung/' . $gedung->gedung_id . '/show_ajax');
                $editUrl = url('/gedung/' . $gedung->gedung_id . '/edit_ajax');
                $deleteUrl = url('/gedung/' . $gedung->gedung_id . '/delete_ajax');

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
        return view('admin.gedung.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gedung_kode' => 'required|string|max:10|unique:m_gedung,gedung_kode',
            'gedung_nama' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $gedung = GedungModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $gedung->gedung_id,
                'gedung_nama' => $gedung->gedung_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit_ajax($gedung_id)
    {
        $gedung = GedungModel::find($gedung_id);
        return view('admin.gedung.edit_ajax', compact('gedung'));
    }

    public function update_ajax(Request $request, $gedung_id)
    {
        $validator = Validator::make($request->all(), [
            'gedung_kode' => 'required|string|max:10|unique:m_gedung,gedung_kode,' . $gedung_id . ',gedung_id',
            'gedung_nama' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $gedung = GedungModel::find($gedung_id);
        if (!$gedung) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        try {
            $gedung->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $gedung->gedung_id,
                'gedung_nama' => $gedung->gedung_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function confirm_ajax($gedung_id)
    {
        $gedung = GedungModel::find($gedung_id);
        return view('admin.gedung.confirm_ajax', compact('gedung'));
    }

    public function delete_ajax($gedung_id)
    {
        $gedung = GedungModel::find($gedung_id);
        if ($gedung) {
            // Cek apakah gedung memiliki lantai terkait
            if ($gedung->lantais()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus gedung karena sudah memiliki lantai terkait.'
                ]);
            }

            $gedung->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Data Gedung tidak ditemukan.'
        ]);
    }

    public function show_ajax($gedung_id)
    {
        $gedung = GedungModel::find($gedung_id);
        return view('admin.gedung.show_ajax', compact('gedung'));
    }

    public function import()
    {
        return view('admin.gedung.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_gedung' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_gedung');
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
                        $gedung_kode = trim($value['A']);
                        $gedung_nama = trim($value['B']);

                        $insert[] = [
                            'gedung_kode' => $gedung_kode,
                            'gedung_nama' => $gedung_nama,
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    GedungModel::insertOrIgnore($insert);
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
        $gedungs = GedungModel::select('gedung_id', 'gedung_kode', 'gedung_nama')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Gedung');
        $sheet->setCellValue('C1', 'Nama Gedung');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($gedungs as $gedung) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $gedung->gedung_kode);
            $sheet->setCellValue('C' . $baris, $gedung->gedung_nama);
            $no++;
            $baris++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Gedung');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Gedung_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        $gedungs = GedungModel::select('gedung_id', 'gedung_kode', 'gedung_nama')->get();

        $data = [
            'gedungs' => $gedungs,
            'title' => 'Laporan Data Gedung'
        ];

        $pdf = Pdf::loadView('admin.gedung.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Gedung ' . date('Y-m-d H-i-s') . '.pdf');
    }
}