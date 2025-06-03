<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FasilitasModel;
use App\Models\RuangModel;
use App\Models\BarangModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class FasilitasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Fasilitas',
            'list' => ['Home', 'Fasilitas']
        ];

        $page = (object) [
            'title' => 'Daftar fasilitas yang terdaftar dalam sistem'
        ];

        $activeMenu = 'fasilitas';

        return view('admin.fasilitas.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $fasilitas = FasilitasModel::with(['ruang', 'barang'])
            ->select('fasilitas_id', 'ruang_id', 'barang_id', 'fasilitas_kode', 'fasilitas_nama', 'keterangan', 'status', 'tahun_pengadaan');

        return DataTables::of($fasilitas)
            ->addIndexColumn()
            ->addColumn('ruang_nama', function ($fasilitas) {
                return $fasilitas->ruang ? $fasilitas->ruang->ruang_nama : '-';
            })
            ->addColumn('barang_nama', function ($fasilitas) {
                return $fasilitas->barang ? $fasilitas->barang->barang_nama : '-';
            })
            ->addColumn('aksi', function ($fasilitas) {
                $showUrl = url('/fasilitas/' . $fasilitas->fasilitas_id . '/show_ajax');
                $editUrl = url('/fasilitas/' . $fasilitas->fasilitas_id . '/edit_ajax');
                $deleteUrl = url('/fasilitas/' . $fasilitas->fasilitas_id . '/delete_ajax');

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
        $ruangs = RuangModel::select('ruang_id', 'ruang_nama')->get();
        $barangs = BarangModel::select('barang_id', 'barang_nama')->get();
        return view('admin.fasilitas.create_ajax', compact('ruangs', 'barangs'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruang_id' => 'required|exists:m_ruang,ruang_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'fasilitas_kode' => 'required|string|max:20|unique:m_fasilitas,fasilitas_kode',
            'fasilitas_nama' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tahun_pengadaan' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $fasilitas = FasilitasModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $fasilitas->fasilitas_id,
                'fasilitas_nama' => $fasilitas->fasilitas_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function edit_ajax($fasilitas_id)
    {
        $fasilitas = FasilitasModel::find($fasilitas_id);
        $ruangs = RuangModel::select('ruang_id', 'ruang_nama')->get();
        $barangs = BarangModel::select('barang_id', 'barang_nama')->get();
        return view('admin.fasilitas.edit_ajax', compact('fasilitas', 'ruangs', 'barangs'));
    }

    public function update_ajax(Request $request, $fasilitas_id)
    {
        $validator = Validator::make($request->all(), [
            'ruang_id' => 'required|exists:m_ruang,ruang_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'fasilitas_kode' => 'required|string|max:20|unique:m_fasilitas,fasilitas_kode,' . $fasilitas_id . ',fasilitas_id',
            'fasilitas_nama' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tahun_pengadaan' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $fasilitas = FasilitasModel::find($fasilitas_id);
        if (!$fasilitas) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        try {
            $fasilitas->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $fasilitas->fasilitas_id,
                'fasilitas_nama' => $fasilitas->fasilitas_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function confirm_ajax($fasilitas_id)
    {
        $fasilitas = FasilitasModel::find($fasilitas_id);
        return view('admin.fasilitas.confirm_ajax', compact('fasilitas'));
    }

    public function delete_ajax($fasilitas_id)
    {
        $fasilitas = FasilitasModel::find($fasilitas_id);

        if ($fasilitas) {
            $fasilitas->delete();
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

    public function show_ajax($fasilitas_id)
    {
        $fasilitas = FasilitasModel::with(['ruang', 'barang'])->find($fasilitas_id);
        return view('admin.fasilitas.show_ajax', compact('fasilitas'));
    }

    public function import()
    {
        return view('admin.fasilitas.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_fasilitas' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_fasilitas');
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
                            'ruang_id' => trim($value['A']),
                            'barang_id' => trim($value['B']),
                            'fasilitas_kode' => trim($value['C']),
                            'fasilitas_nama' => trim($value['D']),
                            'keterangan' => trim($value['E']) ?: null,
                            'status' => trim($value['F']),
                            'tahun_pengadaan' => trim($value['G']) ?: null,
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    FasilitasModel::insertOrIgnore($insert);
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
        $fasilitas = FasilitasModel::with(['ruang', 'barang'])
            ->select('fasilitas_id', 'ruang_id', 'barang_id', 'fasilitas_kode', 'fasilitas_nama', 'keterangan', 'status', 'tahun_pengadaan')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Ruang');
        $sheet->setCellValue('C1', 'Barang');
        $sheet->setCellValue('D1', 'Kode Fasilitas');
        $sheet->setCellValue('E1', 'Nama Fasilitas');
        $sheet->setCellValue('F1', 'Keterangan');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Tahun Pengadaan');
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($fasilitas as $item) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $item->ruang ? $item->ruang->ruang_nama : '-');
            $sheet->setCellValue('C' . $baris, $item->barang ? $item->barang->barang_nama : '-');
            $sheet->setCellValue('D' . $baris, $item->fasilitas_kode);
            $sheet->setCellValue('E' . $baris, $item->fasilitas_nama);
            $sheet->setCellValue('F' . $baris, $item->keterangan ?? '-');
            $sheet->setCellValue('G' . $baris, $item->status);
            $sheet->setCellValue('H' . $baris, $item->tahun_pengadaan ?? '-');
            $no++;
            $baris++;
        }

        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Fasilitas');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Fasilitas_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $fasilitas = FasilitasModel::with(['ruang', 'barang'])
            ->select('fasilitas_id', 'ruang_id', 'barang_id', 'fasilitas_kode', 'fasilitas_nama', 'keterangan', 'status', 'tahun_pengadaan')
            ->get();

        $data = [
            'fasilitas' => $fasilitas,
            'title' => 'Laporan Data Fasilitas'
        ];

        $pdf = Pdf::loadView('admin.fasilitas.export_pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Fasilitas ' . date('Y-m-d H-i-s') . '.pdf');
    }
}