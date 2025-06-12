<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\KriteriaModel;
use App\Models\PairwiseKriteriaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        return view('sarpras.kriteria.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $kriterias = KriteriaModel::select('kriteria_id', 'kriteria_kode', 'kriteria_nama', 'bobot','kriteria_jenis');

        return DataTables::of($kriterias)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kriteria) {
                $showUrl = secure_url('/sarpras/kriteria/' . $kriteria->kriteria_id . '/show_ajax');
                $editUrl = secure_url('/sarpras/kriteria/' . $kriteria->kriteria_id . '/edit_ajax');
                $deleteUrl = secure_url('/sarpras/kriteria/' . $kriteria->kriteria_id . '/delete_ajax');

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
        return view('sarpras.kriteria.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kriteria_kode' => 'required|string|max:10|unique:m_kriteria,kriteria_kode',
            'kriteria_nama' => 'required|string|max:100',
            'bobot' => 'required|numeric|between:0,1',
            'kriteria_jenis' => 'required|in:benefit,cost',
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
        return view('sarpras.kriteria.edit_ajax', compact('kriteria'));
    }

    public function update_ajax(Request $request, $kriteria_id)
    {
        $validator = Validator::make($request->all(), [
            'kriteria_kode' => 'required|string|max:10|unique:m_kriteria,kriteria_kode,' . $kriteria_id . ',kriteria_id',
            'kriteria_nama' => 'required|string|max:100',
            'bobot' => 'required|numeric|between:0,1',
            'kriteria_jenis' => 'required|in:benefit,cost',
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
        return view('sarpras.kriteria.confirm_ajax', compact('kriteria'));
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
        return view('sarpras.kriteria.show_ajax', compact('kriteria'));
    }

    public function import()
    {
        return view('sarpras.kriteria.import');
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
                            'kriteria_jenis' => strtolower(trim($value['D'])) === 'benefit' ? 'benefit' : 'cost',
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
        $sheet->setCellValue('E1', 'Jenis Kriteria');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($kriterias as $kriteria) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $kriteria->kriteria_kode);
            $sheet->setCellValue('C' . $baris, $kriteria->kriteria_nama);
            $sheet->setCellValue('D' . $baris, $kriteria->bobot);
            $sheet->setCellValue('E' . $baris, ucfirst($kriteria->kriteria_jenis));
            $no++;
            $baris++;
        }

        foreach (range('A', 'E') as $columnID) {
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
        $kriterias = KriteriaModel::select('kriteria_id', 'kriteria_kode', 'kriteria_nama', 'bobot', 'kriteria_jenis')->get();

        $data = [
            'kriterias' => $kriterias,
            'title' => 'Laporan Data Kriteria'
        ];

        $pdf = Pdf::loadView('sarpras.kriteria.export_pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Kriteria ' . date('Y-m-d H-i-s') . '.pdf');
    }


    public function showPairwiseForm()
    {
        $kriteria = KriteriaModel::all();
        $pairwise = PairwiseKriteriaModel::all()->keyBy(function ($item) {
            return $item->kriteria_id_1 . '-' . $item->kriteria_id_2;
        });

        return view('sarpras.kriteria.pairwise', compact('kriteria', 'pairwise'));
    }

    public function updatePairwise(Request $request)
    {
        $request->validate([
            'pairwise.*.*' => 'required|numeric|between:0.1,9',
        ]);

        try {
            $kriteria = KriteriaModel::all();
            foreach ($kriteria as $i => $k1) {
                for ($j = $i + 1; $j < $kriteria->count(); $j++) {
                    $k2 = $kriteria[$j];
                    $nilai = $request->input("pairwise.{$k1->kriteria_id}.{$k2->kriteria_id}");
                    PairwiseKriteriaModel::updateOrCreate(
                        ['kriteria_id_1' => $k1->kriteria_id, 'kriteria_id_2' => $k2->kriteria_id],
                        ['nilai' => $nilai]
                    );
                }
            }

            // Calculate AHP weights
            KriteriaModel::calculateAHPWeights();

            return redirect()->back()->with('success', 'Pairwise comparisons updated and weights calculated.');
        } catch (\Exception $e) {
            Log::error('Failed to update pairwise comparisons', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }

}