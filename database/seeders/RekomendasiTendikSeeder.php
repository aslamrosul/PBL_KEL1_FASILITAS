<?php

namespace Database\Seeders;
use Carbon\Carbon;

use App\Models\RekomendasiTendikModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekomendasiTendikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        RekomendasiTendikModel::insert([
            [
                'laporan_id' => 1,
                'nilai_kriteria' => json_encode([
                    'DMPK' => 80,
                    'JMH' => 70,
                    'KRSK' => 60,
                    'KTS' => 50
                ]),
                'skor_total' => 70.0,
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
