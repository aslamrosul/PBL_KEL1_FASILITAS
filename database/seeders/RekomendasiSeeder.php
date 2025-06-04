<?php

namespace Database\Seeders;
use Carbon\Carbon;

use App\Models\RekomendasiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekomendasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        RekomendasiModel::insert([
            [
                'laporan_id' => 1,
                'rekom_mahasiswa' => json_encode(['skor' => 80, 'kriteria' => ['DMPK' => 90, 'JMH' => 80, 'KRSK' => 70, 'KTS' => 60]]),
                'rekom_dosen' => json_encode(['skor' => 75, 'kriteria' => ['DMPK' => 85, 'JMH' => 75, 'KRSK' => 65, 'KTS' => 55]]),
                'rekom_tendik' => json_encode(['skor' => 70, 'kriteria' => ['DMPK' => 80, 'JMH' => 70, 'KRSK' => 60, 'KTS' => 50]]),
                'skor_final' => 75.0,
                'bobot_id' => 1,
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
