<?php

namespace Database\Seeders;
use Carbon\Carbon;

use App\Models\RekomendasiDosenModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekomendasiDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        RekomendasiDosenModel::insert([
            [
                'laporan_id' => 1,
                'nilai_kriteria' => json_encode([
                    'DMPK' => 85,
                    'JMH' => 75,
                    'KRSK' => 65,
                    'KTS' => 55
                ]),
                'skor_total' => 75.0,
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
