<?php

namespace Database\Seeders;

use App\Models\PeriodeModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    public function run()
    {
        PeriodeModel::insert([
            [
                'kode_periode' => '2024-GENAP',
                'nama_periode' => 'Semester Genap 2023/2024',
                'tanggal_mulai' => Carbon::create(2024, 2, 1),
                'tanggal_selesai' => Carbon::create(2024, 6, 30),
                'is_aktif' => true,
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_periode' => '2024-GANJIL',
                'nama_periode' => 'Semester Ganjil 2024/2025',
                'tanggal_mulai' => Carbon::create(2024, 9, 1),
                'tanggal_selesai' => Carbon::create(2025, 1, 31),
                'is_aktif' => false,
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
