<?php

namespace Database\Seeders;
use Carbon\Carbon;

use App\Models\RekomendasiMahasiswaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekomendasiMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        RekomendasiMahasiswaModel::insert([
            [
                'laporan_id' => 1,
                'nilai_kriteria' => json_encode([
                    'DMPK' => 90,
                    'JMH' => 80,
                    'KRSK' => 70,
                    'KTS' => 60
                ]),
                'skor_total' => 80.0,
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
