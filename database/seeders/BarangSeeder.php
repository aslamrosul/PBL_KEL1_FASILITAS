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
           // Elektronik & Komputer
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'PC', 'barang_nama' => 'Komputer Desktop', 'bobot_prioritas' => 0.95],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'PRJ', 'barang_nama' => 'Proyektor', 'bobot_prioritas' => 0.85],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'SCR', 'barang_nama' => 'Layar Proyektor', 'bobot_prioritas' => 0.70],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'SPKR', 'barang_nama' => 'Speaker Aktif', 'bobot_prioritas' => 0.60],
            ['kategori_id' => 1, 'klasifikasi_id' => 3, 'barang_kode' => 'ACSP', 'barang_nama' => 'AC Split', 'bobot_prioritas' => 0.90],
            ['kategori_id' => 1, 'klasifikasi_id' => 1, 'barang_kode' => 'MON', 'barang_nama' => 'Monitor Komputer', 'bobot_prioritas' => 0.80],

            // Furnitur
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'KRS', 'barang_nama' => 'Kursi Kuliah', 'bobot_prioritas' => 0.75],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'MJA', 'barang_nama' => 'Meja Kuliah', 'bobot_prioritas' => 0.75],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'MJDS', 'barang_nama' => 'Meja Dosen', 'bobot_prioritas' => 0.85],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'LEM', 'barang_nama' => 'Lemari Arsip', 'bobot_prioritas' => 0.65],
            ['kategori_id' => 2, 'klasifikasi_id' => 2, 'barang_kode' => 'RBK', 'barang_nama' => 'Rak Buku', 'bobot_prioritas' => 0.55],

            // Utilitas & Keamanan
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'WIFI', 'barang_nama' => 'Access Point WiFi', 'bobot_prioritas' => 0.90],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'CCTV', 'barang_nama' => 'Kamera CCTV', 'bobot_prioritas' => 0.88],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'BW', 'barang_nama' => 'Whiteboard', 'bobot_prioritas' => 0.50],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'PAP', 'barang_nama' => 'Papan Pengumuman', 'bobot_prioritas' => 0.45],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'KOTAK', 'barang_nama' => 'Kotak P3K', 'bobot_prioritas' => 0.40],
            ['kategori_id' => 3, 'klasifikasi_id' => 3, 'barang_kode' => 'ALARM', 'barang_nama' => 'Alarm Kebakaran', 'bobot_prioritas' => 0.70],
        ]);
    }
}