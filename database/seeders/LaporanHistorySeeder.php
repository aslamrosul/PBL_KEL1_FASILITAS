<?php

namespace Database\Seeders;

use App\Models\LaporanHistoryModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LaporanHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        LaporanHistoryModel::insert([
            [
                'laporan_id' => 1,
                'user_id' => 2,
                'aksi' => 'buat laporan',
                'keterangan' => 'Laporan dibuat oleh mahasiswa',
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'laporan_id' => 1,
                'user_id' => 1,
                'aksi' => 'verifikasi laporan',
                'keterangan' => 'Laporan diterima oleh admin',
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
