<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\PeriodeModel;
use App\Models\BobotPrioritasModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanSarprasController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Manajemen Laporan Kerusakan',
            'list' => ['Home', 'Sarpras', 'Laporan Kerusakan']
        ];

        $page = (object) [
            'title' => 'Daftar Laporan Kerusakan Fasilitas Kampus'
        ];

        $activeMenu = 'laporan';
        $periodes = PeriodeModel::all();
        $bobots = BobotPrioritasModel::all();

        return view('sarpras.laporan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'periodes' => $periodes,
            'bobots' => $bobots
        ]);
    }

    public function list(Request $request)
    {
        $laporans = LaporanModel::with(['user', 'periode', 'fasilitas', 'bobotPrioritas'])
            ->select('laporan_id', 'user_id', 'periode_id', 'fasilitas_id', 'judul', 'status', 'bobot_id', 'created_at');

        // Filter berdasarkan periode
        if ($request->periode_id) {
            $laporans->where('periode_id', $request->periode_id);
        }

        // Filter berdasarkan status
        if ($request->status) {
            $laporans->where('status', $request->status);
        }

        // Filter berdasarkan prioritas
        if ($request->bobot_id) {
            $laporans->where('bobot_id', $request->bobot_id);
        }

        return DataTables::of($laporans)
            ->addIndexColumn()
            ->addColumn('nama_pelapor', function ($laporan) {
                return $laporan->user->nama;
            })
            ->addColumn('periode', function ($laporan) {
                return $laporan->periode->nama_periode;
            })
            ->addColumn('fasilitas', function ($laporan) {
                return $laporan->fasilitas->fasilitas_nama ?? '-';
            })
            ->addColumn('prioritas', function ($laporan) {
                return $laporan->bobotPrioritas->bobot_nama ?? '-';
            })
            ->addColumn('aksi', function ($laporan) {
                $btn = '<a href="'.url('/sarpras/laporan/'.$laporan->laporan_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/sarpras/laporan/'.$laporan->laporan_id.'/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<a href="'.url('/sarpras/laporan/'.$laporan->laporan_id.'/prioritas').'" class="btn btn-primary btn-sm">Prioritas</a>';
                return $btn;
            })
            ->editColumn('status', function ($laporan) {
                $badge = '';
                switch ($laporan->status) {
                    case 'pending':
                        $badge = '<span class="badge bg-warning">Pending</span>';
                        break;
                    case 'diterima':
                        $badge = '<span class="badge bg-info">Diterima</span>';
                        break;
                    case 'ditolak':
                        $badge = '<span class="badge bg-danger">Ditolak</span>';
                        break;
                    case 'diproses':
                        $badge = '<span class="badge bg-primary">Diproses</span>';
                        break;
                    case 'selesai':
                        $badge = '<span class="badge bg-success">Selesai</span>';
                        break;
                    default:
                        $badge = '<span class="badge bg-secondary">Unknown</span>';
                }
                return $badge;
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function show($id)
    {
        $laporan = LaporanModel::with(['user', 'periode', 'fasilitas', 'bobotPrioritas', 'histories.user', 'perbaikans.teknisi'])->find($id);

        if (!$laporan) {
            return redirect('/sarpras/laporan')->with('error', 'Data laporan tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Laporan',
            'list' => ['Home', 'Sarpras', 'Laporan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Laporan Kerusakan'
        ];

        $activeMenu = 'laporan';
        $teknisis = UserModel::whereHas('level', function($query) {
            $query->where('level_kode', 'TEK');
        })->get();

        return view('sarpras.laporan.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'laporan' => $laporan,
            'teknisis' => $teknisis,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit($id)
    {
        $laporan = LaporanModel::find($id);

        if (!$laporan) {
            return redirect('/sarpras/laporan')->with('error', 'Data laporan tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Laporan',
            'list' => ['Home', 'Sarpras', 'Laporan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Laporan Kerusakan'
        ];

        $activeMenu = 'laporan';
        $bobots = BobotPrioritasModel::all();

        return view('sarpras.laporan.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'laporan' => $laporan,
            'bobots' => $bobots,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string',
            'alasan_penolakan' => 'required_if:status,ditolak',
            'bobot_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $laporan = LaporanModel::find($id);
        if (!$laporan) {
            return redirect('/sarpras/laporan')->with('error', 'Data laporan tidak ditemukan');
        }

        $laporan->status = $request->status;
        $laporan->bobot_id = $request->bobot_id;
        $laporan->alasan_penolakan = $request->alasan_penolakan;
        $laporan->save();

        // Tambahkan history
        $laporan->histories()->create([
            'user_id' => auth()->id(),
            'aksi' => 'update',
            'keterangan' => 'Mengubah status laporan menjadi ' . $request->status
        ]);

        return redirect('/sarpras/laporan')->with('success', 'Status laporan berhasil diperbarui');
    }

    public function updatePrioritas($id)
    {
        $laporan = LaporanModel::find($id);

        if (!$laporan) {
            return redirect('/sarpras/laporan')->with('error', 'Data laporan tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Update Prioritas Laporan',
            'list' => ['Home', 'Sarpras', 'Laporan', 'Prioritas']
        ];

        $page = (object) [
            'title' => 'Update Prioritas Laporan'
        ];

        $activeMenu = 'laporan';
        $bobots = BobotPrioritasModel::all();

        return view('sarpras.laporan.prioritas', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'laporan' => $laporan,
            'bobots' => $bobots,
            'activeMenu' => $activeMenu
        ]);
    }

    public function storePrioritas(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bobot_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $laporan = LaporanModel::find($id);
        if (!$laporan) {
            return redirect('/sarpras/laporan')->with('error', 'Data laporan tidak ditemukan');
        }

        $laporan->bobot_id = $request->bobot_id;
        $laporan->save();

        // Tambahkan history
        $laporan->histories()->create([
            'user_id' => auth()->id(),
            'aksi' => 'update_priority',
            'keterangan' => 'Mengubah prioritas laporan menjadi ' . $laporan->bobotPrioritas->bobot_nama
        ]);

        return redirect('/sarpras/laporan')->with('success', 'Prioritas laporan berhasil diperbarui');
    }

    public function assignTeknisi(Request $request, $laporan_id)
    {
        $validator = Validator::make($request->all(), [
            'teknisi_id' => 'required|integer',
            'catatan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $laporan = LaporanModel::find($laporan_id);
        if (!$laporan) {
            return redirect('/sarpras/laporan')->with('error', 'Data laporan tidak ditemukan');
        }

        // Buat perbaikan baru
        $perbaikan = $laporan->perbaikans()->create([
            'teknisi_id' => $request->teknisi_id,
            'status' => 'diproses',
            'catatan' => $request->catatan,
            'tanggal_mulai' => now()
        ]);

        // Update status laporan
        $laporan->status = 'diproses';
        $laporan->save();

        // Tambahkan history
        $laporan->histories()->create([
            'user_id' => auth()->id(),
            'aksi' => 'assign_teknisi',
            'keterangan' => 'Menugaskan teknisi untuk perbaikan'
        ]);

        return redirect('/sarpras/laporan/'.$laporan_id)->with('success', 'Teknisi berhasil ditugaskan');
    }

    public function exportPdf()
    {
        $laporans = LaporanModel::with(['user', 'periode', 'fasilitas', 'bobotPrioritas'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'laporans' => $laporans,
            'title' => 'Laporan Kerusakan Fasilitas Kampus'
        ];

        $pdf = Pdf::loadView('sarpras.laporan.export_pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Laporan Kerusakan Fasilitas Kampus.pdf');
    }
}