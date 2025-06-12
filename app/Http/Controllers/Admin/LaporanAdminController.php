<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\LaporanHistoryModel;
use App\Models\GedungModel;
use App\Models\LantaiModel;
use App\Models\RuangModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\PeriodeModel;
use App\Models\FasilitasModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;


use Illuminate\Support\Facades\Log; // Untuk logging
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login
use Illuminate\Support\Facades\DB; // Untuk transaksi database
use Illuminate\Support\Facades\Storage; // Untuk penanganan file foto

class LaporanAdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Laporan',
            'list' => ['Home', 'Laporan']
        ];

        $page = (object) [
            'title' => 'Daftar laporan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'laporan'; // Menu aktif diubah

        // Anda mungkin ingin menampilkan filter atau data tambahan di sini
        $gedungs = GedungModel::all();
        $lantais = LantaiModel::all();
        $ruangs = RuangModel::all();
        $barangs = BarangModel::all();
        $periodes = PeriodeModel::all();
        $fasilitas = FasilitasModel::all();
        $users = UserModel::all(); // Jika laporan terkait dengan user yang membuat

        return view('admin.laporan.index', [ // View diubah ke laporan
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'gedungs' => $gedungs,
            'lantais' => $lantais,
            'ruangs' => $ruangs,
            'barangs' => $barangs,
            'periodes' => $periodes,
            'fasilitas' => $fasilitas,
            'users' => $users,
        ]);
    }

    public function list(Request $request)
        {
            // Mengambil data laporan dengan eager loading relasi yang dibutuhkan
            // untuk kolom 'Pelapor', 'Fasilitas', 'Periode', 'Gedung', 'Lantai', 'Ruang', dan 'Barang'.
            $laporans = LaporanModel::with('user', 'fasilitas', 'periode', 'gedung', 'lantai', 'ruang', 'barang')
                                    ->select(
                                        'laporan_id',
                                        'judul',
                                        'user_id',
                                        'fasilitas_id',
                                        'periode_id',
                                        'status',
                                        'tanggal_selesai',
                                        // Hapus 'gedung', 'lantai', 'ruang', 'barang' dari sini
                                        // karena kita akan mengambilnya dari relasi
                                    );

            // ... (filter jika ada)

            return DataTables::of($laporans)
                ->addIndexColumn()
                ->addColumn('user_nama', function ($laporan) {
                    return $laporan->user->nama ?? '-';
                })
                ->addColumn('fasilitas', function ($laporan) {
                    return $laporan->fasilitas->fasilitas_nama ?? '-';
                })
                ->addColumn('periode', function ($laporan) {
                    return $laporan->periode->periode_nama ?? '-';
                })
                // Tambahkan kolom untuk Gedung, Lantai, Ruang, Barang dari relasi
                ->addColumn('gedung_nama', function ($laporan) {
                    return $laporan->gedung->gedung_nama ?? '-'; // Asumsi kolom nama di GedungModel adalah 'gedung_nama'
                })
                ->addColumn('lantai_nomor', function ($laporan) {
                    return $laporan->lantai->lantai_nomor ?? '-'; // Asumsi kolom nomor di LantaiModel adalah 'lantai_nomor'
                })
                ->addColumn('ruang_nama', function ($laporan) {
                    return $laporan->ruang->ruang_nama ?? '-'; // Asumsi kolom nama di RuangModel adalah 'ruang_nama'
                })
                ->addColumn('barang_nama', function ($laporan) {
                    return $laporan->barang->barang_nama ?? '-'; // Asumsi kolom nama di BarangModel adalah 'barang_nama'
                })
                ->addColumn('aksi', function ($laporan) {
                    $showUrl = secure_url('/laporan-admin/' . $laporan->laporan_id . '/show_ajax');
                    $editUrl = secure_url('/laporan-admin/' . $laporan->laporan_id . '/edit_ajax');

                    return '
                        <button onclick="modalAction(\'' . $showUrl . '\')" class="btn btn-info btn-sm" title="Lihat Laporan">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-warning btn-sm" title="Edit Laporan">
                            <i class="fa fa-edit"></i>
                        </button>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        public function show_ajax($laporan_id)
        {
            // Mengambil laporan berdasarkan ID dengan eager loading semua relasi yang mungkin
            // diperlukan untuk ditampilkan di modal detail.
            $laporan = LaporanModel::with(
                'user',
                'periode',
                'fasilitas',
                'gedung', // Relasi ke GedungModel
                'lantai', // Relasi ke LantaiModel
                'ruang',  // Relasi ke RuangModel
                'barang', // Relasi ke BarangModel
                'bobotPrioritas', // Relasi ke BobotPrioritasModel
                'histories.user', // Relasi ke LaporanHistoryModel, dan juga user di dalamnya
                'perbaikans',     // Relasi ke PerbaikanModel
                'feedback'        // Relasi ke FeedbackModel
            )->find($laporan_id);
    
            return view('admin.laporan.show_ajax', compact('laporan'));
        }

        public function edit_ajax($id)
        {
            $laporan = LaporanModel::with(['user', 'fasilitas'])->findOrFail($id);
            return view('admin.laporan.edit_ajax', compact('laporan'));
        }
    
        public function update_status(Request $request, $id)
        {
            Log::info('update_status dipanggil untuk ID ' . $id . ' dengan data: ', $request->all());
    
            $validator = Validator::make($request->all(), [
                'status' => 'required|string|in:Menunggu,Diterima,Ditolak,Diproses,Selesai',
                'keterangan' => 'nullable|string|max:500',
                'alasan_penolakan' => 'required_if:status,Ditolak|nullable|string|max:500',
            ]);
    
            if ($validator->fails()) {
                Log::error('Validasi gagal untuk ID ' . $id . ': ', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validasi gagal'
                ], 422);
            }
    
            $laporan = LaporanModel::findOrFail($id);
    
            $oldStatus = $laporan->status;
            $newStatus = $request->status;
            $alasanPenolakan = $request->alasan_penolakan;
            $keteranganHistori = $request->keterangan;
    
            $userId = Auth::id();
            if (is_null($userId)) {
                Log::error('User tidak terautentikasi saat mencoba update status laporan ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login untuk melakukan aksi ini.'
                ], 401); // Unauthorized
            }
    
            DB::beginTransaction();
            try {
                $laporan->status = $newStatus;
    
                if ($newStatus === 'Ditolak') {
                    $laporan->alasan_penolakan = $alasanPenolakan;
                    $laporan->tanggal_selesai = null;
                } elseif ($newStatus === 'Selesai') {
                    $laporan->alasan_penolakan = null;
                    if (is_null($laporan->tanggal_selesai)) {
                        $laporan->tanggal_selesai = now();
                    }
                } else {
                    $laporan->alasan_penolakan = null;
                    $laporan->tanggal_selesai = null;
                }
    
                if ($laporan->save()) {
                    Log::info('Laporan ID ' . $id . ' status berhasil diperbarui di database.');
                } else {
                    Log::error('Laporan ID ' . $id . ' status GAGAL diperbarui di database (save() mengembalikan false).');
                    throw new \Exception('Gagal menyimpan perubahan status laporan.');
                }
    
                // Tentukan nilai 'aksi' berdasarkan status baru
                $aksi = '';
                switch ($newStatus) {
                    case 'Menunggu':
                        $aksi = 'status_menunggu';
                        break;
                    case 'Diterima':
                        $aksi = 'status_diterima';
                        break;
                    case 'Ditolak':
                        $aksi = 'status_ditolak';
                        break;
                    case 'Diproses':
                        $aksi = 'status_diproses';
                        break;
                    case 'Selesai':
                        $aksi = 'status_selesai';
                        break;
                    default:
                        $aksi = 'status_update'; // Fallback
                        break;
                }
    
                // Membuat entri histori laporan sesuai dengan kolom tabel t_laporan_history
                $history = LaporanHistoryModel::create([
                    'laporan_id' => $laporan->laporan_id,
                    'user_id' => $userId,
                    'aksi' => $aksi,
                    'keterangan' => $keteranganHistori,
                    // created_at dan updated_at akan diisi otomatis oleh Laravel karena $timestamps = true di model
                ]);
    
                if ($history) {
                    Log::info('Histori laporan untuk ID ' . $id . ' berhasil dibuat.');
                } else {
                    Log::error('Histori laporan untuk ID ' . $id . ' GAGAL dibuat.');
                    throw new \Exception('Gagal membuat entri histori laporan.');
                }
    
                DB::commit();
    
                Log::info('Status laporan berhasil diperbarui untuk ID ' . $id . ' dari ' . $oldStatus . ' menjadi ' . $newStatus . '. Transaksi berhasil.');
    
                return response()->json([
                    'success' => true,
                    'message' => 'Status laporan berhasil diperbarui',
                    'laporan' => $laporan
                ], 200);
    
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('ERROR dalam transaksi update_status untuk ID ' . $id . ': ' . $e->getMessage(), ['exception' => $e]);
    
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui status laporan: ' . $e->getMessage()
                ], 500);
            }
        }

        public function update(Request $request, $laporan_id)
    {
        $laporan = LaporanModel::find($laporan_id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:m_user,user_id',
            'periode_id' => 'required|exists:m_periode,periode_id',
            'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gedung_id' => 'nullable|exists:m_gedung,gedung_id',
            'lantai_id' => 'nullable|exists:m_lantai,lantai_id',
            'ruang_id' => 'nullable|exists:m_ruang,ruang_id',
            'barang_id' => 'nullable|exists:m_barang,barang_id',
            'status' => 'required|string|in:Menunggu,Diterima,Ditolak,Diproses,Selesai',
            'alasan_penolakan' => 'nullable|string',
            'tanggal_selesai' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $fotoPath = $laporan->foto_path;
        if ($request->hasFile('foto_path')) {
            if ($laporan->foto_path) {
                $oldPath = str_replace('storage/', 'public/', $laporan->foto_path);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
            $fotoPath = $request->file('foto_path')->store('public/laporan_photos');
            $fotoPath = str_replace('public/', 'storage/', $fotoPath);
        }

        $laporan->update([
            'user_id' => $request->user_id,
            'periode_id' => $request->periode_id,
            'fasilitas_id' => $request->fasilitas_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto_path' => $fotoPath,
            'gedung_id' => $request->gedung_id,
            'lantai_id' => $request->lantai_id,
            'ruang_id' => $request->ruang_id,
            'barang_id' => $request->barang_id,
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan_penolakan,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return response()->json($laporan, 200);
    }
}