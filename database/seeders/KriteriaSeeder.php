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
                'kriteria_kode' => 'DMPK',
                'kriteria_nama' => 'Dampak Akademik',
                'bobot' => 0.4
            ],
            [
                'kriteria_kode' => 'JMH',
                'kriteria_nama' => 'Jumlah Pengguna',
                'bobot' => 0.3
            ],
            [
                'kriteria_kode' => 'KRSK',
                'kriteria_nama' => 'Tingkat Kerusakan',
                'bobot' => 0.2
            ],
            [
                'kriteria_kode' => 'KTS',
                'kriteria_nama' => 'Ketersediaan Sparepart',
                'bobot' => 0.1
            ],
        ]);
    }
}
