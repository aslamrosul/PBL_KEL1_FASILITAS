<?php

namespace Database\Seeders;

use App\Models\KriteriaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        KriteriaModel::insert([
            [
                'kriteria_kode' => 'FREK',
                'kriteria_nama' => 'Frekuensi Laporan',
                'bobot' => 0.4,
                'kriteria_jenis' => 'benefit'
            ],
            [
                'kriteria_kode' => 'USIA',
                'kriteria_nama' => 'Usia Fasilitas',
                'bobot' => 0.3,
                'kriteria_jenis' => 'cost'
            ],
            [
                'kriteria_kode' => 'KLASIFIKASI',
                'kriteria_nama' => 'Prioritas Klasifikasi',
                'bobot' => 0.2,
                'kriteria_jenis' => 'benefit'
            ],
            [
                'kriteria_kode' => 'KATEGORI',
                'kriteria_nama' => 'Kategori Fasilitas',
                'bobot' => 0.1,
                'kriteria_jenis' => 'benefit'
            ],
            [
                'kriteria_kode' => 'KONDISI',
                'kriteria_nama' => 'Kondisi Fasilitas',
                'bobot' => 0.5,
                'kriteria_jenis' => 'benefit'
            ]
        ]);
    }
}
