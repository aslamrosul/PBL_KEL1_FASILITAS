<?php

namespace Database\Seeders;

use App\Models\KategoriModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        KategoriModel::insert([
            ['kategori_kode' => 'ELK', 'kategori_nama' => 'Elektronik'],
            ['kategori_kode' => 'FNT', 'kategori_nama' => 'Furniture'],
            ['kategori_kode' => 'JRN', 'kategori_nama' => 'Jaringan'],
            ['kategori_kode' => 'AC', 'kategori_nama' => 'Air Conditioner'],
        ]);
    }
}
