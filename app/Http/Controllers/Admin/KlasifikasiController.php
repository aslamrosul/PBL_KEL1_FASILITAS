<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlasifikasiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KlasifikasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Klasifikasi',
            'list' => ['Home', 'Klasifikasi']
        ];

        $page = (object) [
            'title' => 'Daftar klasifikasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'klasifikasi';

        return view('admin.klasifikasi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $klasifikasis = KlasifikasiModel::select('klasifikasi_id', 'klasifikasi_kode', 'klasifikasi_nama');

        return DataTables::of($klasifikasis)
            ->addIndexColumn()
            ->addColumn('aksi', function ($klasifikasi) {
                $showUrl = secure_url('/klasifikasi/' . $klasifikasi->klasifikasi_id . '/show_ajax');
                $editUrl = secure_url('/klasifikasi/' . $klasifikasi->klasifikasi_id . '/edit_ajax');
                $deleteUrl = secure_url('/klasifikasi/' . $klasifikasi->klasifikasi_id . '/delete_ajax');

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
        return view('admin.klasifikasi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'klasifikasi_kode' => 'required|string|max:10|unique:m_klasifikasi,klasifikasi_kode',
            'klasifikasi_nama' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $klasifikasi = KlasifikasiModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $klasifikasi->klasifikasi_id,
                'klasifikasi_nama' => $klasifikasi->klasifikasi_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit_ajax($klasifikasi_id)
    {
        $klasifikasi = KlasifikasiModel::find($klasifikasi_id);
        return view('admin.klasifikasi.edit_ajax', compact('klasifikasi'));
    }

    public function update_ajax(Request $request, $klasifikasi_id)
    {
        $validator = Validator::make($request->all(), [
            'klasifikasi_kode' => 'required|string|max:10|unique:m_klasifikasi,klasifikasi_kode,' . $klasifikasi_id . ',klasifikasi_id',
            'klasifikasi_nama' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $klasifikasi = KlasifikasiModel::find($klasifikasi_id);
        if (!$klasifikasi) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        try {
            $klasifikasi->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $klasifikasi->klasifikasi_id,
                'klasifikasi_nama' => $klasifikasi->klasifikasi_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function confirm_ajax($klasifikasi_id)
    {
        $klasifikasi = KlasifikasiModel::find($klasifikasi_id);
        return view('admin.klasifikasi.confirm_ajax', compact('klasifikasi'));
    }

    public function delete_ajax($klasifikasi_id)
    {
        $klasifikasi = KlasifikasiModel::find($klasifikasi_id);

        if ($klasifikasi) {
            $klasifikasi->delete();
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

    public function show_ajax($klasifikasi_id)
    {
        $klasifikasi = KlasifikasiModel::find($klasifikasi_id);
        return view('admin.klasifikasi.show_ajax', compact('klasifikasi'));
    }

    public function import()
    {
        return view('admin.klasifikasi.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_klasifikasi' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_klasifikasi');
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
                            'klasifikasi_kode' => trim($value['A']),
                            'klasifikasi_nama' => trim($value['B']),
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    KlasifikasiModel::insertOrIgnore($insert);
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
        $klasifikasis = KlasifikasiModel::select('klasifikasi_id', 'klasifikasi_kode', 'klasifikasi_nama')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Klasifikasi');
        $sheet->setCellValue('C1', 'Nama Klasifikasi');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($klasifikasis as $klasifikasi) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $klasifikasi->klasifikasi_kode);
            $sheet->setCellValue('C' . $baris, $klasifikasi->klasifikasi_nama);
            $no++;
            $baris++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Klasifikasi');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Klasifikasi_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $klasifikasis = KlasifikasiModel::select('klasifikasi_id', 'klasifikasi_kode', 'klasifikasi_nama')->get();

        $data = [
            'klasifikasis' => $klasifikasis,
            'title' => 'Laporan Data Klasifikasi'
        ];

        $pdf = Pdf::loadView('admin.klasifikasi.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Klasifikasi ' . date('Y-m-d H-i-s') . '.pdf');
    }
}
