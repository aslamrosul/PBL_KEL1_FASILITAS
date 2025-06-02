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
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'PC', 'barang_nama' => 'Komputer'],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'PRJ', 'barang_nama' => 'Proyektor'],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'KRS', 'barang_nama' => 'Kursi'],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'WIFI', 'barang_nama' => 'Access Point WiFi'],
            ['kategori_id' => 1, 'klasifikasi_id' => 3, 'barang_kode' => 'ACSP', 'barang_nama' => 'AC Split'],
        ]);
    }
}
