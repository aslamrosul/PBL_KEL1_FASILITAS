<?php

namespace Database\Seeders;

use App\Models\PerbaikanModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerbaikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/PerbaikanSeeder.php
    public function run()
    {
        PerbaikanModel::insert([
            [
                'laporan_id' => 1,
                'teknisi_id' => 6,
                'tanggal_mulai' => Carbon::now(),
                'tanggal_selesai' => null,
                'tanggal_ditolak' => null,
                'status' => 'selesai',
                'catatan' => 'Periksa power supply',
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        PerbaikanModel::insert([
            [
                'laporan_id' => 2,
                'teknisi_id' => 6,
                'tanggal_mulai' => Carbon::now(),
                'tanggal_selesai' => null,
                'tanggal_ditolak' => null,
                'status' => 'diproses',
                'catatan' => 'Periksa power supply',
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
