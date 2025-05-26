<?php

namespace Database\Seeders;

use App\Models\BobotPrioritasModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BobotPrioritasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BobotPrioritasModel::insert([
            [
                'bobot_kode' => 'HIGH',
                'bobot_nama' => 'High Priority',
                'skor_min' => 80,
                'skor_max' => 100,
                'tindakan' => 'Perbaikan <24 jam'
            ],
            [
                'bobot_kode' => 'MED',
                'bobot_nama' => 'Medium Priority',
                'skor_min' => 50,
                'skor_max' => 79,
                'tindakan' => 'Perbaikan <72 jam'
            ],
            [
                'bobot_kode' => 'LOW',
                'bobot_nama' => 'Low Priority',
                'skor_min' => 0,
                'skor_max' => 49,
                'tindakan' => 'Perbaikan <1 minggu'
            ],
        ]);
    }
}
