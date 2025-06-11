<?php

namespace Database\Seeders;

use App\Models\BarangModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run()
    {
        BarangModel::insert([
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'PC', 'barang_nama' => 'Komputer Desktop'],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'PRJ', 'barang_nama' => 'Proyektor'],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'SCR', 'barang_nama' => 'Layar Proyektor'],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'SPKR', 'barang_nama' => 'Speaker Aktif'],
            ['kategori_id' => 1, 'klasifikasi_id' => 3, 'barang_kode' => 'ACSP', 'barang_nama' => 'AC Split'],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'MON', 'barang_nama' => 'Monitor Komputer'],

            // Furnitur
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'KRS', 'barang_nama' => 'Kursi Kuliah'],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'MJA', 'barang_nama' => 'Meja Kuliah'],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'MJDS', 'barang_nama' => 'Meja Dosen'],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'LEM', 'barang_nama' => 'Lemari Arsip'],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'RBK', 'barang_nama' => 'Rak Buku'],

            // Utilitas & Keamanan
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'WIFI', 'barang_nama' => 'Access Point WiFi'],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'CCTV', 'barang_nama' => 'Kamera CCTV'],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'BW', 'barang_nama' => 'Whiteboard'],
        ]);
    }
}