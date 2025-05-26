<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LevelModel;

class LevelSeeder extends Seeder
{
    public function run()
    {
        LevelModel::insert([
            ['level_kode' => 'ADM', 'level_nama' => 'Administrator'],
            ['level_kode' => 'MHS', 'level_nama' => 'Mahasiswa'],
            ['level_kode' => 'DSN', 'level_nama' => 'Dosen'],
            ['level_kode' => 'TNK', 'level_nama' => 'Tenaga Kependidikan'],
            ['level_kode' => 'SPR', 'level_nama' => 'Sarana Prasarana'],
            ['level_kode' => 'TKN', 'level_nama' => 'Teknisi'],
        ]);
    }
}