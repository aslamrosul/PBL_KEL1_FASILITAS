<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\PerbaikanModel;
use App\Models\PerbaikanDetailModel;
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
            ->whereIn('status', ['menunggu', 'diproses']);

        return DataTables::of($perbaikans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($perbaikan) {
                $btn = '<button onclick="modalAction(\'' . url('/teknisi/perbaikan/' . $perbaikan->perbaikan_id . '/edit_ajax') . '\')" class="btn btn-primary btn-sm mr-1 title="Proses Perbaikan">
                        <i class="fa fa-wrench"></i>
                        </button>';
                $btn .= '<button onclick="modalAction(\'' . url('/teknisi/perbaikan/' . $perbaikan->perbaikan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm title="Lihat Detail Perbaikan">
                            <i class="fa fa-eye"></i> 
                        </button>';
                return $btn;
            })
            ->editColumn('status', function ($perbaikan) {
                return $this->getStatusBadge($perbaikan->status);
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
                return '<button onclick="modalAction(\'' . url('/teknisi/perbaikan/' . $perbaikan->perbaikan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> Detail
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

        // Hanya izinkan perubahan ke status 'selesai' dari 'menunggu' atau 'diproses'
        if ($request->status !== 'selesai' || !in_array($perbaikan->status, ['menunggu', 'diproses'])) {
            return response()->json([
                'status' => false,
                'message' => 'Hanya dapat mengubah status ke Selesai dari status Menunggu atau Diproses'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:selesai',
            'foto_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tindakan.*' => 'required|string',
            'deskripsi.*' => 'nullable|string',
            'total_biaya' => 'required|numeric|min:0'
        ], [
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

        DB::beginTransaction();
        try {
            $data = [
                'status' => $request->status,
                'catatan' => $request->catatan,
                'tanggal_selesai' => now(),
                'total_biaya' => $request->total_biaya
            ];

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

            $perbaikan->update($data);

            // Simpan detail perbaikan
            PerbaikanDetailModel::where('perbaikan_id', $perbaikan_id)->delete();
            foreach ($request->tindakan as $key => $tindakan) {
                PerbaikanDetailModel::create([
                    'perbaikan_id' => $perbaikan_id,
                    'tindakan' => $tindakan,
                    'deskripsi' => $request->deskripsi[$key] ?? null,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Status perbaikan berhasil diupdate',
                'redirect' => url('/teknisi/perbaikan')
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
            case 'menunggu':
                return '<span class="badge badge-warning">Menunggu</span>';
            case 'diproses':
                return '<span class="badge badge-primary">Diproses</span>';
            case 'selesai':
                return '<span class="badge badge-success">Selesai</span>';
            case 'ditolak':
                return '<span class="badge badge-danger">Ditolak</span>';
            default:
                return '<span class="badge badge-secondary">Unknown</span>';
        }
    }

}
