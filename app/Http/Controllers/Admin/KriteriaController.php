<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KriteriaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KriteriaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kriteria',
            'list' => ['Home', 'Kriteria']
        ];

        $page = (object) [
            'title' => 'Daftar kriteria yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kriteria';

        return view('admin.kriteria.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $kriterias = KriteriaModel::select('kriteria_id', 'kriteria_kode', 'kriteria_nama', 'bobot');

        return DataTables::of($kriterias)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kriteria) {
                $showUrl = url('/kriteria/' . $kriteria->kriteria_id . '/show_ajax');
                $editUrl = url('/kriteria/' . $kriteria->kriteria_id . '/edit_ajax');
                $deleteUrl = url('/kriteria/' . $kriteria->kriteria_id . '/delete_ajax');

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
        return view('admin.kriteria.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kriteria_kode' => 'required|string|max:10|unique:m_kriteria_gdss,kriteria_kode',
            'kriteria_nama' => 'required|string|max:100',
            'bobot' => 'required|numeric|between:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $kriteria = KriteriaModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $kriteria->kriteria_id,
                'kriteria_nama' => $kriteria->kriteria_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit_ajax($kriteria_id)
    {
        $kriteria = KriteriaModel::find($kriteria_id);
        return view('admin.kriteria.edit_ajax', compact('kriteria'));
    }

    public function update_ajax(Request $request, $kriteria_id)
    {
        $validator = Validator::make($request->all(), [
            'kriteria_kode' => 'required|string|max:10|unique:m_kriteria_gdss,kriteria_kode,' . $kriteria_id . ',kriteria_id',
            'kriteria_nama' => 'required|string|max:100',
            'bobot' => 'required|numeric|between:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $kriteria = KriteriaModel::find($kriteria_id);
        if (!$kriteria) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        try {
            $kriteria->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $kriteria->kriteria_id,
                'kriteria_nama' => $kriteria->kriteria_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function confirm_ajax($kriteria_id)
    {
        $kriteria = KriteriaModel::find($kriteria_id);
        return view('admin.kriteria.confirm_ajax', compact('kriteria'));
    }

    public function delete_ajax($kriteria_id)
    {
        $kriteria = KriteriaModel::find($kriteria_id);

        if ($kriteria) {
            $kriteria->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    public function show_ajax($kriteria_id)
    {
        $kriteria = KriteriaModel::find($kriteria_id);
        return view('admin.kriteria.show_ajax', compact('kriteria'));
    }

    public function import()
    {
        return view('admin.kriteria.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_kriteria' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_kriteria');
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
                            'kriteria_kode' => trim($value['A']),
                            'kriteria_nama' => trim($value['B']),
                            'bobot' => floatval($value['C']),
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    KriteriaModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
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
        $kriterias = KriteriaModel::select('kriteria_id', 'kriteria_kode', 'kriteria_nama', 'bobot')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kriteria');
        $sheet->setCellValue('C1', 'Nama Kriteria');
        $sheet->setCellValue('D1', 'Bobot');
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($kriterias as $kriteria) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $kriteria->kriteria_kode);
            $sheet->setCellValue('C' . $baris, $kriteria->kriteria_nama);
            $sheet->setCellValue('D' . $baris, $kriteria->bobot);
            $no++;
            $baris++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Kriteria');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Kriteria_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $kriterias = KriteriaModel::select('kriteria_id', 'kriteria_kode', 'kriteria_nama', 'bobot')->get();

        $data = [
            'kriterias' => $kriterias,
            'title' => 'Laporan Data Kriteria'
        ];

        $pdf = Pdf::loadView('admin.kriteria.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Kriteria ' . date('Y-m-d H-i-s') . '.pdf');
    }
}