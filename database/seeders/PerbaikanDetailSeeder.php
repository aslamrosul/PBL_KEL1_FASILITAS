<?php

namespace Database\Seeders;

use App\Models\PerbaikanDetailModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerbaikanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PerbaikanDetailModel::insert([
            [
                'perbaikan_id' => 1,
                'tindakan' => 'Ganti power supply',
                'deskripsi' => 'Power supply komputer diganti dengan yang baru',
                'bahan' => 'Power supply 500W',
                'biaya' => 350000
            ],
        ]);
    }
}
