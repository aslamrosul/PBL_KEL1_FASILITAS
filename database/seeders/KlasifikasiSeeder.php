<?php

namespace Database\Seeders;;

use App\Models\KlasifikasiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KlasifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        KlasifikasiModel::insert([
            ['klasifikasi_kode' => 'ACAD', 'klasifikasi_nama' => 'Pendukung Pembelajaran', 'bobot_prioritas' => 0.50],
            ['klasifikasi_kode' => 'NONACAD', 'klasifikasi_nama' => 'Fasilitas Umum', 'bobot_prioritas' => 0.30],
            ['klasifikasi_kode' => 'SUPPORT', 'klasifikasi_nama' => 'Pendukung Operasional', 'bobot_prioritas' => 0.20],
        ]);
    }
}
