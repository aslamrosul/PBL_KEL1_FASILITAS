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
            ['klasifikasi_kode' => 'ACAD', 'klasifikasi_nama' => 'Pendukung Pembelajaran'],
            ['klasifikasi_kode' => 'NONACAD', 'klasifikasi_nama' => 'Fasilitas Umum'],
            ['klasifikasi_kode' => 'SUPPORT', 'klasifikasi_nama' => 'Pendukung Operasional'],
  
        ]);
    }
}
