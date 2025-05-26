<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LevelModel;

class LevelSeeder extends Seeder
{
    public function run()
    {
        LevelModel::insert([
            ['level_kode' => 'ADM', 'level_nama' => 'Administrator', 'level_route' => 'admin'],
            ['level_kode' => 'MHS', 'level_nama' => 'Mahasiswa', 'level_route' => 'pelapor'],
            ['level_kode' => 'DSN', 'level_nama' => 'Dosen', 'level_route' => 'pelapor'],
            ['level_kode' => 'TNK', 'level_nama' => 'Tenaga Kependidikan', 'level_route' => 'pelapor'],
            ['level_kode' => 'SPR', 'level_nama' => 'Sarana Prasarana', 'level_route' => 'sarpras'],
            ['level_kode' => 'TKN', 'level_nama' => 'Teknisi', 'level_route' => 'teknisi'],
        ]);
    }
}