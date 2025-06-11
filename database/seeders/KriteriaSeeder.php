<?php

namespace Database\Seeders;

use App\Models\KriteriaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Kosongkan tabel dulu jika ada data lama
         KriteriaModel::insert([
            [
                'kriteria_kode' => 'frekuensi',
                'kriteria_nama' => 'Frekuensi Laporan Kerusakan',
                'kriteria_jenis' => 'benefit',
                'bobot' => 0.30,
              
            ],
            [
                'kriteria_kode' => 'usia',
                'kriteria_nama' => 'Usia Fasilitas',
                'kriteria_jenis' => 'cost',
                'bobot' => 0.25,
             
            ],
            [
                'kriteria_kode' => 'kondisi',
                'kriteria_nama' => 'Kondisi Fasilitas',
                'kriteria_jenis' => 'benefit',
                'bobot' => 0.20,
              
            ],
            [
                'kriteria_kode' => 'barang',
                'kriteria_nama' => 'Prioritas Jenis Barang',
                'kriteria_jenis' => 'benefit',
                'bobot' => 0.15,
              
            ],
            [
                'kriteria_kode' => 'klasifikasi',
                'kriteria_nama' => 'Klasifikasi Fasilitas',
                'kriteria_jenis' => 'benefit',
                'bobot' => 0.10,
               
            ],
           ]);

       
    }
}