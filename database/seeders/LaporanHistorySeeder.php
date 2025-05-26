<?php

namespace Database\Seeders;

use App\Models\LaporanHistoryModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'keterangan' => 'Laporan dibuat oleh mahasiswa'
            ],
            [
                'laporan_id' => 1,
                'user_id' => 1,
                'aksi' => 'verifikasi laporan',
                'keterangan' => 'Laporan diverifikasi oleh admin'
            ],
        ]);
    }
}
