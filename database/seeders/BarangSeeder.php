<?php

namespace Database\Seeders;

use App\Models\BarangModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BarangModel::insert([
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'PC', 'barang_nama' => 'Komputer',  'prioritas_barang' => 0.50,],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'PRJ', 'barang_nama' => 'Proyektor', 'prioritas_barang' => 0.30],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'KRS', 'barang_nama' => 'Kursi', 'prioritas_barang' => 0.20],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'WIFI', 'barang_nama' => 'Access Point WiFi', 'prioritas_barang' => 0.40],
            ['kategori_id' => 1, 'klasifikasi_id' => 3, 'barang_kode' => 'ACSP', 'barang_nama' => 'AC Split', 'prioritas_barang' => 0.60],
   
        ]);
    }
}
