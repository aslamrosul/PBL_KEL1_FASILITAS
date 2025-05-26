<?php

namespace Database\Seeders;

use App\Models\LaporanModel;

use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run()
    {
        LaporanModel::insert([
            [
                'user_id' => 2,
                'periode_id' => 1,
                'fasilitas_id' => 1,
                'judul' => 'Komputer Tidak Menyala',
                'deskripsi' => 'Komputer di Lab 1 tidak bisa menyala ketika dinyalakan',
                'foto_path' => null,
                'bobot_id' => 1,
                'status' => 'diproses',
                'alasan_penolakan' => null,
                'tanggal_selesai' => null
            ],
            [
                'user_id' => 3,
                'periode_id' => 1,
                'fasilitas_id' => 2,
                'judul' => 'Proyektor Berkedip',
                'deskripsi' => 'Proyektor di Lab 1 sering berkedip ketika digunakan',
                'foto_path' => null,
                'bobot_id' => '',
                'status' => 'pending',
                'alasan_penolakan' => null,
                'tanggal_selesai' => null
            ],
        ]);
    }
}
