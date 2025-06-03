<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\KlasifikasiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';

        $kategori = KategoriModel::all();
        $klasifikasi = KlasifikasiModel::all();

        return view('admin.barang.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'klasifikasi' => $klasifikasi,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $barangs = BarangModel::select('barang_id', 'kategori_id', 'klasifikasi_id', 'barang_kode', 'barang_nama')
            ->with('kategori')
            ->with('klasifikasi');
        if ($request->klasifikasi_id) {
            $barangs->where('klasifikasi_id', $request->klasifikasi_id);
        }

        if ($request->kategori_id) {
            $barangs->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($barangs)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $showUrl = url('/barang/' . $barang->barang_id . '/show_ajax');
                $editUrl = url('/barang/' . $barang->barang_id . '/edit_ajax');
                $deleteUrl = url('/barang/' . $barang->barang_id . '/delete_ajax');

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
        $kategori = KategoriModel::all();
        $klasifikasi = KlasifikasiModel::all();

        return view('admin.barang.create_ajax', compact('kategori', 'klasifikasi'));
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'kategori_id' => 'required|integer',
            'klasifikasi_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $barang = BarangModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'id' => $barang->barang_id,
                'barang_nama' => $barang->barang_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah data: ' . $e->getMessage()
            ]);
        }
    }

    public function show_ajax($barang_id)
    {
        $barang = BarangModel::with('kategori', 'klasifikasi')->find($barang_id);
        return view('admin.barang.show_ajax', compact('barang'));
    }

    public function edit_ajax($barang_id)
    {
        $barang = BarangModel::find($barang_id);
        $kategori = KategoriModel::all();
        $klasifikasi = KlasifikasiModel::all();

        return view('admin.barang.edit_ajax', compact('barang', 'kategori', 'klasifikasi'));
    }

    public function update_ajax(Request $request, $barang_id)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $barang_id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'kategori_id' => 'required|integer',
            'klasifikasi_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $barang = BarangModel::find($barang_id);
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $barang->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate',
            'id' => $barang->barang_id,
            'barang_nama' => $barang->barang_nama
        ]);
    }

    public function confirm_ajax($barang_id)
    {
        $barang = BarangModel::find($barang_id);
        return view('admin.barang.confirm_ajax', compact('barang'));
    }

    public function delete_ajax($barang_id)
    {
        $barang = BarangModel::find($barang_id);
        if ($barang) {
            $barang->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Data Barang tidak ditemukan.'
        ]);
    }

    public function import()
    {
        return view('admin.barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang');
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
                        $barang_kode = trim($value['A']);
                        $barang_nama = trim($value['B']);
                        $kategori_nama = trim($value['C']);
                        $klasifikasi_nama = trim($value['D']);

                        $kategori = KategoriModel::where('kategori_nama', $kategori_nama)->first();
                        $klasifikasi = KlasifikasiModel::where('klasifikasi_nama', $klasifikasi_nama)->first();

                        if ($kategori && $klasifikasi) {
                            $insert[] = [
                                'barang_kode'  => $barang_kode,
                                'barang_nama'  => $barang_nama,
                                'kategori_id'  => $kategori->kategori_id,
                                'klasifikasi_id'  => $klasifikasi->klasifikasi_id,
                                'created_at'   => now(),
                            ];
                        } else {

                            $errors[] = "Baris {$baris}: Kategori '{$kategori_nama}' atau Baris {$baris}: Klasifikasi '{$klasifikasi_nama}' tidak terdaftar di database.";
                        }
                    }
                }

                if (count($insert) > 0) {
                    BarangModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => count($errors) === 0,
                    'message' => count($errors) === 0 ? 'Data berhasil diimport' : 'Data sebagian berhasil diimport',
                    'errors'  => $errors
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
        $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'kategori_id', 'klasifikasi_id')
            ->with('kategori', 'klasifikasi')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Kategori');
        $sheet->setCellValue('E1', 'Klasifikasi');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($barangs as $barang) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $barang->barang_kode);
            $sheet->setCellValue('C' . $baris, $barang->barang_nama);
            $sheet->setCellValue('D' . $baris, $barang->kategori->kategori_nama ?? '');
            $sheet->setCellValue('E' . $baris, $barang->klasifikasi->klasifikasi_nama ?? '');
            $no++;
            $baris++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Barang');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Barang_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        $barangs = BarangModel::with('kategori', 'klasifikasi')->get();

        $data = [
            'barangs' => $barangs,
            'title' => 'Laporan Data Barang'
        ];

        $pdf = Pdf::loadView('admin.barang.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Barang ' . date('Y-m-d H-i-s') . '.pdf');
    }
}
