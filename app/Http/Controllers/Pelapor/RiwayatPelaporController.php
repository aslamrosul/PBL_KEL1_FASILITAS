<?php

namespace App\Http\Controllers\Pelapor;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RiwayatPelaporController extends Controller
{
   public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat Laporan',
            'list' => ['Home', 'Riwayat']
        ];

        $page = (object) [
            'title' => 'Riwayat laporan yang sudah selesai'
        ];

        $activeMenu = 'riwayat';

        return view('pelapor.laporan.riwayat', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

   public function list(Request $request)
{
    if ($request->ajax()) {
        $laporan = LaporanModel::where('user_id', Auth::id())
            ->whereIn('status', ['selesai', 'ditolak']) // ini perbaikannya
            ->with(['periode', 'fasilitas', 'bobotPrioritas'])
            ->select('t_laporan.*');

        return DataTables::of($laporan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($laporan) {
                $showUrl = url('/pelapor/laporan/' . $laporan->laporan_id . '/show_ajax');
                return '
                    <button onclick="modalAction(\'' . $showUrl . '\')" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> Detail
                    </button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}

}
