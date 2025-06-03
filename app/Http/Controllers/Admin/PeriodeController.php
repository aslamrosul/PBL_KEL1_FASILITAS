<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PeriodeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Periode',
            'list' => ['Home', 'Periode']
        ];

        $page = (object) [
            'title' => 'Daftar periode yang terdaftar dalam sistem'
        ];

        $activeMenu = 'periode';

        return view('admin.periode.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $periodes = PeriodeModel::select('periode_id', 'periode_kode', 'periode_nama', 'tanggal_mulai', 'tanggal_selesai', 'is_aktif');

        return DataTables::of($periodes)
            ->addIndexColumn()
            ->addColumn('aksi', function ($periode) {
                $showUrl = url('/periode/' . $periode->periode_id . '/show_ajax');
                $editUrl = url('/periode/' . $periode->periode_id . '/edit_ajax');
                $deleteUrl = url('/periode/' . $periode->periode_id . '/delete_ajax');

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
            ->editColumn('is_aktif', function ($periode) {
                return $periode->is_aktif ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Tidak Aktif</span>';
            })
            ->rawColumns(['aksi', 'is_aktif'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.periode.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'periode_kode' => 'required|string|max:10|unique:m_periode,periode_kode',
            'periode_nama' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'is_aktif' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            // Nonaktifkan semua periode jika periode baru aktif
            if ($request->is_aktif) {
                PeriodeModel::where('is_aktif', true)->update(['is_aktif' => false]);
            }

            $periode = PeriodeModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $periode->periode_id,
                'periode_nama' => $periode->periode_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit_ajax($periode_id)
    {
        $periode = PeriodeModel::find($periode_id);
        return view('admin.periode.edit_ajax', compact('periode'));
    }

    public function update_ajax(Request $request, $periode_id)
    {
        $validator = Validator::make($request->all(), [
            'periode_kode' => 'required|string|max:10|unique:m_periode,periode_kode,' . $periode_id . ',periode_id',
            'periode_nama' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'is_aktif' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $periode = PeriodeModel::find($periode_id);
        if (!$periode) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        try {
            // Nonaktifkan semua periode jika periode ini diaktifkan
            if ($request->is_aktif) {
                PeriodeModel::where('is_aktif', true)->where('periode_id', '!=', $periode_id)->update(['is_aktif' => false]);
            }

            $periode->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $periode->periode_id,
                'periode_nama' => $periode->periode_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function confirm_ajax($periode_id)
    {
        $periode = PeriodeModel::find($periode_id);
        return view('admin.periode.confirm_ajax', compact('periode'));
    }

    public function delete_ajax($periode_id)
    {
        $periode = PeriodeModel::find($periode_id);
        if ($periode) {
            // Cek apakah periode memiliki laporan
            if ($periode->laporans()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus periode karena sudah memiliki laporan terkait.'
                ]);
            }

            $periode->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Data Periode tidak ditemukan.'
        ]);
    }

    public function show_ajax($periode_id)
    {
        $periode = PeriodeModel::find($periode_id);
        return view('admin.periode.show_ajax', compact('periode'));
    }

    public function import()
    {
        return view('admin.periode.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_periode' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_periode');
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
                        $periode_kode = trim($value['A']);
                        $periode_nama = trim($value['B']);
                        $tanggal_mulai = trim($value['C']);
                        $tanggal_selesai = trim($value['D']);
                        $is_aktif = strtolower(trim($value['E'])) === 'aktif' ? 1 : 0;

                        $insert[] = [
                            'periode_kode' => $periode_kode,
                            'periode_nama' => $periode_nama,
                            'tanggal_mulai' => $tanggal_mulai,
                            'tanggal_selesai' => $tanggal_selesai,
                            'is_aktif' => $is_aktif,
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // Nonaktifkan semua periode jika ada yang aktif di data import
                    if (collect($insert)->contains('is_aktif', 1)) {
                        PeriodeModel::where('is_aktif', true)->update(['is_aktif' => false]);
                    }

                    PeriodeModel::insertOrIgnore($insert);
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
        $periodes = PeriodeModel::all();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Periode');
        $sheet->setCellValue('C1', 'Nama Periode');
        $sheet->setCellValue('D1', 'Tanggal Mulai');
        $sheet->setCellValue('E1', 'Tanggal Selesai');
        $sheet->setCellValue('F1', 'Status');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($periodes as $periode) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $periode->periode_kode);
            $sheet->setCellValue('C' . $baris, $periode->periode_nama);
            $sheet->setCellValue('D' . $baris, $periode->tanggal_mulai);
            $sheet->setCellValue('E' . $baris, $periode->tanggal_selesai);
            $sheet->setCellValue('F' . $baris, $periode->is_aktif ? 'Aktif' : 'Tidak Aktif');
            $no++;
            $baris++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Periode');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Periode_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        $periodes = PeriodeModel::all();

        $data = [
            'periodes' => $periodes,
            'title' => 'Laporan Data Periode'
        ];

        $pdf = Pdf::loadView('admin.periode.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Periode ' . date('Y-m-d H-i-s') . '.pdf');
    }
}