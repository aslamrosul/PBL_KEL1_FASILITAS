<?php

namespace Database\Seeders;

use App\Models\BobotPrioritasModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BobotPrioritasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BobotPrioritasModel::insert([
            [
                'bobot_kode' => 'URG',
                'bobot_nama' => 'Urgent',
                'skor_min' => 0.8,
                'skor_max' => 1.0,
                'tindakan' => 'Perbaikan dalam 24 jam'
            ],
            [
                'bobot_kode' => 'HIGH',
                'bobot_nama' => 'High Priority',
                'skor_min' => 0.6,
                'skor_max' => 0.79,
                'tindakan' => 'Perbaikan dalam 48 jam'
            ],
            [
                'bobot_kode' => 'MED',
                'bobot_nama' => 'Medium Priority',
                'skor_min' => 0.4,
                'skor_max' => 0.59,
                'tindakan' => 'Perbaikan dalam 72 jam'
            ],
            [
                'bobot_kode' => 'LOW',
                'bobot_nama' => 'Low Priority',
                'skor_min' => 0.2,
                'skor_max' => 0.39,
                'tindakan' => 'Perbaikan dalam 1 minggu'
            ],
            [
                'bobot_kode' => 'MINOR',
                'bobot_nama' => 'Minor Issue',
                'skor_min' => 0,
                'skor_max' => 0.19,
                'tindakan' => 'Perbaikan dalam 2 minggu'
            ]

        ]);
    }
}
