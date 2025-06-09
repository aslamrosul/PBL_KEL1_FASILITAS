<?php

namespace App\Http\Controllers\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\LaporanModel;
use App\Models\PerbaikanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenugasanController extends Controller
{
      public function assign_ajax($id)
    {
        $laporan = LaporanModel::find($id);
        $teknisi = UserModel::whereHas('level', function ($query) {
            $query->where('level_kode', 'TKN'); // Atau pakai where('level_id', 3) jika pakai angka
        })->get();
        return view('sarpras.laporan.assign_ajax', compact('laporan', 'teknisi'));
    }

    public function assign(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'teknisi_id' => 'required|exists:m_user,user_id',
            'catatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            // Buat perbaikan baru
            $perbaikan = PerbaikanModel::create([
                'laporan_id' => $id,
                'teknisi_id' => $request->teknisi_id,
                'tanggal_mulai' => now(),
                'status' => 'diproses',
                'catatan' => $request->catatan
            ]);

            // Update status laporan
            LaporanModel::find($id)->update(['status' => 'diproses']);

            return response()->json([
                'status' => true,
                'message' => 'Teknisi berhasil ditugaskan',
                'id' => $perbaikan->perbaikan_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menugaskan teknisi: ' . $e->getMessage()
            ]);
        }
    }
}
