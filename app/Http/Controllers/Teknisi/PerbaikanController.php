<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\NotifikasiModel;
use App\Models\PerbaikanModel;
use App\Models\PerbaikanDetailModel;
use App\Models\RiwayatPenugasanModel;
use App\Models\UserModel;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PerbaikanController extends Controller
{
    // Menampilkan daftar perbaikan aktif
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Perbaikan',
            'list' => ['Home', 'Perbaikan']
        ];

        $page = (object) [
            'title' => 'Daftar perbaikan yang perlu ditangani'
        ];

        $activeMenu = 'perbaikan';

        return view('teknisi.perbaikan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan riwayat perbaikan selesai
    public function riwayat()
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat Perbaikan',
            'list' => ['Home', 'Riwayat Perbaikan']
        ];

        $page = (object) [
            'title' => 'Daftar perbaikan yang sudah selesai'
        ];

        $activeMenu = 'riwayat-perbaikan';

        return view('teknisi.perbaikan.riwayat', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // DataTables untuk perbaikan aktif
    public function list(Request $request)
    {
        $perbaikans = PerbaikanModel::select('perbaikan_id', 'laporan_id', 'teknisi_id', 'tanggal_mulai', 'tanggal_selesai', 'status', 'catatan')
            ->with(['laporan', 'laporan.fasilitas', 'teknisi'])
            ->where('teknisi_id', auth()->user()->user_id)
            ->whereIn('status', ['dalam_antrian', 'diproses']);

        return DataTables::of($perbaikans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($perbaikan) {
                $btn = '<button onclick="modalAction(\'' . secure_url('/teknisi/perbaikan/' . $perbaikan->perbaikan_id . '/edit_ajax') . '\')" class="btn btn-primary btn-sm mr-1 title="Proses Perbaikan">
                        <i class="fa fa-wrench"></i>
                        </button>';
                $btn .= '<button onclick="modalAction(\'' . secure_url('/teknisi/perbaikan/' . $perbaikan->perbaikan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm title="Lihat Detail Perbaikan">
                            <i class="fa fa-eye"></i> 
                        </button>';
                return $btn;
            })
            ->editColumn('status', function ($perbaikan) {
                 return $perbaikan->status;
            })
            ->editColumn('laporan.judul', function ($perbaikan) {
                 return $perbaikan->laporan->judul;
            })
            ->editColumn('laporan.fasilitas.fasilitas_nama', function ($perbaikan) {
                 return $perbaikan->laporan->fasilitas->fasilitas_nama ?? '-';
            })
             ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function listRiwayat(Request $request)
    {
        $perbaikans = PerbaikanModel::select('perbaikan_id', 'laporan_id', 'teknisi_id', 'tanggal_mulai', 'tanggal_selesai', 'status', 'catatan')
            ->with(['laporan', 'laporan.fasilitas', 'teknisi'])
            ->where('teknisi_id', auth()->user()->user_id)
            ->where('status', 'selesai');

        return DataTables::of($perbaikans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($perbaikan) {
                return '<button onclick="modalAction(\'' . secure_url('/teknisi/perbaikan/' . $perbaikan->perbaikan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i>  
                        </button>';
            })
            ->editColumn('status', function ($perbaikan) {
                return $this->getStatusBadge($perbaikan->status);
            })
            ->rawColumns(['aksi', 'status'])
            ->make(true);
    }

    public function edit_ajax($perbaikan_id)
    {
        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi', 'details'])
            ->where('teknisi_id', auth()->user()->user_id)
            ->find($perbaikan_id);

        if (!$perbaikan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return view('teknisi.perbaikan.edit_ajax', compact('perbaikan'));
    }

    public function show_ajax($perbaikan_id)
    {
        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi', 'details'])
            ->where('teknisi_id', auth()->user()->user_id)
            ->find($perbaikan_id);

        if (!$perbaikan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return view('teknisi.perbaikan.show_ajax', compact('perbaikan'));
    }

    public function update_ajax(Request $request, $perbaikan_id)
    {
        $perbaikan = PerbaikanModel::where('teknisi_id', auth()->user()->user_id)
            ->find($perbaikan_id);

        if (!$perbaikan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Validate allowed status transitions
        $allowedStatuses = ['dalam_antrian', 'diproses', 'selesai'];
        if (
            !in_array($request->status, $allowedStatuses) ||
            ($request->status === 'diproses' && $perbaikan->status !== 'dalam_antrian') ||
            ($request->status === 'selesai' && !in_array($perbaikan->status, ['dalam_antrian', 'diproses']))
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Transisi status tidak valid'
            ], 403);
        }

        // Define validation rules based on status
        $rules = [
            'status' => 'required|in:dalam_antrian,diproses,selesai',
            'catatan' => 'nullable|string',
        ];

        if ($request->status === 'selesai') {
            $rules = array_merge($rules, [
                'foto_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'tindakan.*' => 'required|string',
                'deskripsi.*' => 'nullable|string',
                'total_biaya' => 'required|numeric|min:0'
            ]);
        }

        $validator = Validator::make($request->all(), $rules, [
            'tindakan.*.required' => 'Tindakan wajib diisi ketika status selesai',
            'total_biaya.required' => 'Total biaya wajib diisi ketika status selesai'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Prevent updates to restricted fields when status is diproses
        if ($perbaikan->status === 'diproses' && $request->status !== 'selesai') {
            if (
                $request->hasFile('foto_perbaikan') || $request->has('tindakan') ||
                $request->has('deskripsi') || $request->has('total_biaya')
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat mengubah foto, tindakan, deskripsi, atau total biaya saat status diproses'
                ], 403);
            }
        }

        DB::beginTransaction();
        try {
            $data = [
                'status' => $request->status,
                'catatan' => $request->catatan,
            ];

            // Handle fields for selesai status
            if ($request->status === 'selesai') {
                $data['tanggal_selesai'] = now();
                $data['total_biaya'] = $request->total_biaya;

                // Handle upload foto perbaikan
                if ($request->hasFile('foto_perbaikan')) {
                    $foto = $request->file('foto_perbaikan');
                    $fotoName = time() . '_' . $foto->getClientOriginalName();
                    $foto->move(public_path('images/perbaikan'), $fotoName);
                    $data['foto_perbaikan'] = 'images/perbaikan/' . $fotoName;

                    // Hapus foto lama jika ada
                    if ($perbaikan->foto_perbaikan && file_exists(public_path($perbaikan->foto_perbaikan))) {
                        unlink(public_path($perbaikan->foto_perbaikan));
                    }
                }
            }

            $perbaikan->update($data);

            // Update status_penugasan in RiwayatPenugasanModel
            $statusPenugasan = $request->status === 'diproses' ? 'dikerjakan' : ($request->status === 'selesai' ? 'selesai' : 'ditugaskan');
            RiwayatPenugasanModel::where('laporan_id', $perbaikan->laporan_id)
                ->where('teknisi_id', $perbaikan->teknisi_id)
                ->update(['status_penugasan' => $statusPenugasan]);

            // Handle detail perbaikan for selesai status
            if ($request->status === 'selesai') {
                PerbaikanDetailModel::where('perbaikan_id', $perbaikan_id)->delete();
                foreach ($request->tindakan as $key => $tindakan) {
                    PerbaikanDetailModel::create([
                        'perbaikan_id' => $perbaikan_id,
                        'tindakan' => $tindakan,
                        'deskripsi' => $request->deskripsi[$key] ?? null,
                    ]);
                }
            }

            // Update laporan status
            $laporanStatus = $request->status === 'selesai' ? 'selesai' : 'diproses';
            $laporan = LaporanModel::find($perbaikan->laporan_id);
            $laporan->update(['status' => $laporanStatus]);

            // Notify Sarpras about status_penugasan
            $sarprasUsers = UserModel::whereHas('level', function ($query) {
                $query->where('level_kode', 'SPR');
            })->get();

            foreach ($sarprasUsers as $sarpras) {
                NotifikasiModel::create([
                    'judul' => 'Perubahan Status Penugasan',
                    'pesan' => "Status penugasan untuk laporan '{$laporan->judul}' telah diubah menjadi '{$statusPenugasan}'.",
                    'user_id' => $sarpras->user_id,
                    'laporan_id' => $perbaikan->laporan_id,
                    'tipe' => 'status_penugasan',
                    'dibaca' => false,
                ]);
            }

            // Notify Pelapor about status laporan
            NotifikasiModel::create([
                'judul' => 'Perubahan Status Laporan',
                'pesan' => "Status laporan '{$laporan->judul}' telah diubah menjadi '{$laporanStatus}'.",
                'user_id' => $laporan->user_id,
                'laporan_id' => $perbaikan->laporan_id,
                'tipe' => 'status_laporan',
                'dibaca' => false,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Status perbaikan berhasil diupdate',
                'redirect' => secure_url('/teknisi/perbaikan')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate perbaikan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getStatusBadge($status)
    {
        switch ($status) {
            case 'dalam_antrian':
                return '<span class="badge badge-warning">Dalam Antrian</span>';
            case 'diproses':
                return '<span class="badge badge-primary">Diproses</span>';
            case 'selesai':
                return '<span class="badge badge-success">Selesai</span>';
            default:
                return '<span class="badge badge-secondary">Unknown</span>';
        }
    }
}