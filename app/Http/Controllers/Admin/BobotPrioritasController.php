<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BobotPrioritasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BobotPrioritasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Bobot Prioritas',
            'list' => ['Home', 'Bobot Prioritas']
        ];

        $page = (object) [
            'title' => 'Daftar bobot prioritas yang terdaftar dalam sistem'
        ];

        $activeMenu = 'bobot-prioritas';

        return view('admin.bobot-prioritas.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $bobots = BobotPrioritasModel::select('bobot_id', 'bobot_kode', 'bobot_nama', 'skor_min', 'skor_max', 'tindakan');

        return DataTables::of($bobots)
            ->addIndexColumn()
            ->addColumn('aksi', function ($bobot) {
                $editUrl = url('/bobot-prioritas/' . $bobot->bobot_id . '/edit_ajax');
                return '
                    <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function edit_ajax($bobot_id)
    {
        $bobot = BobotPrioritasModel::find($bobot_id);
        return view('admin.bobot-prioritas.edit_ajax', compact('bobot'));
    }

    public function update_ajax(Request $request, $bobot_id)
    {
        $validator = Validator::make($request->all(), [
            'skor_min' => 'required|integer|min:0',
            'skor_max' => 'required|integer|min:0|gte:skor_min',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $bobot = BobotPrioritasModel::find($bobot_id);
        if (!$bobot) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        try {
            $bobot->update([
                'skor_min' => $request->skor_min,
                'skor_max' => $request->skor_max
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate',
                'id' => $bobot->bobot_id,
                'bobot_nama' => $bobot->bobot_nama
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }
}