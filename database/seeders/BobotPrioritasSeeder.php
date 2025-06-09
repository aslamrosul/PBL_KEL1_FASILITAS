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
                'skor_min' => 80,
                'skor_max' => 100,
                'tindakan' => 'Perbaikan dalam 24 jam',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bobot_kode' => 'HIGH',
                'bobot_nama' => 'High Priority',
                'skor_min' => 60,
                'skor_max' => 79,
                'tindakan' => 'Perbaikan dalam 48 jam',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bobot_kode' => 'MED',
                'bobot_nama' => 'Medium Priority',
                'skor_min' => 40,
                'skor_max' => 59,
                'tindakan' => 'Perbaikan dalam 72 jam',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bobot_kode' => 'LOW',
                'bobot_nama' => 'Low Priority',
                'skor_min' => 20,
                'skor_max' => 39,
                'tindakan' => 'Perbaikan dalam 1 minggu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'bobot_kode' => 'MINOR',
                'bobot_nama' => 'Minor Issue',
                'skor_min' => 0,
                'skor_max' => 19,
                'tindakan' => 'Perbaikan dalam 2 minggu',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
