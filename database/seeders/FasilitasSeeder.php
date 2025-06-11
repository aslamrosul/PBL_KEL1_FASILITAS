<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\FasilitasModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run()
    {
        FasilitasModel::insert([
            // Lab Komputer 1 (R101)
            [
                'ruang_id' => 1,
                'barang_id' => 1, // Komputer Desktop
                'fasilitas_kode' => 'PC-R101-01',
                'fasilitas_nama' => 'Komputer Desktop 1',
                'keterangan' => 'PC Intel Core i5, 8GB RAM, 256GB SSD',
                'status' => 'baik',
                'tahun_pengadaan' => '2020',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 1,
                'barang_id' => 6, // Monitor Komputer
                'fasilitas_kode' => 'MON-R101-01',
                'fasilitas_nama' => 'Monitor 24"',
                'keterangan' => 'Monitor LED 24 inch',
                'status' => 'baik',
                'tahun_pengadaan' => '2020',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 1,
                'barang_id' => 2, // Proyektor
                'fasilitas_kode' => 'PRJ-R101-01',
                'fasilitas_nama' => 'Proyektor Epson',
                'keterangan' => 'Proyektor 3600 lumens',
                'status' => 'baik',
                'tahun_pengadaan' => '2021',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 1,
                'barang_id' => 3, // Layar Proyektor
                'fasilitas_kode' => 'SCR-R101-01',
                'fasilitas_nama' => 'Layar Proyektor',
                'keterangan' => 'Layar 120 inch',
                'status' => 'baik',
                'tahun_pengadaan' => '2021',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Lab Komputer 2 (R102)
            [
                'ruang_id' => 2,
                'barang_id' => 1, // Komputer Desktop
                'fasilitas_kode' => 'PC-R102-01',
                'fasilitas_nama' => 'Komputer Desktop 1',
                'keterangan' => 'PC Intel Core i5, 8GB RAM, 512GB SSD',
                'status' => 'baik',
                'tahun_pengadaan' => '2021',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 2,
                'barang_id' => 5, // AC Split
                'fasilitas_kode' => 'AC-R102-01',
                'fasilitas_nama' => 'AC Split 1',
                'keterangan' => 'AC Daikin 1 PK',
                'status' => 'baik',
                'tahun_pengadaan' => '2020',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Kelas A (R201)
            [
                'ruang_id' => 3,
                'barang_id' => 7, // Kursi Kuliah
                'fasilitas_kode' => 'KRS-R201-01',
                'fasilitas_nama' => 'Kursi Kuliah',
                'keterangan' => 'Set kursi kuliah (30 unit)',
                'status' => 'baik',
                'tahun_pengadaan' => '2019',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 3,
                'barang_id' => 8, // Meja Kuliah
                'fasilitas_kode' => 'MJA-R201-01',
                'fasilitas_nama' => 'Meja Kuliah',
                'keterangan' => 'Set meja kuliah (15 unit)',
                'status' => 'baik',
                'tahun_pengadaan' => '2019',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 3,
                'barang_id' => 12, // Access Point WiFi
                'fasilitas_kode' => 'WIFI-R201-01',
                'fasilitas_nama' => 'Access Point WiFi',
                'keterangan' => 'TP-Link EAP245',
                'status' => 'baik',
                'tahun_pengadaan' => '2022',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Kelas B (R202)
            [
                'ruang_id' => 4,
                'barang_id' => 9, // Meja Dosen
                'fasilitas_kode' => 'MJDS-R202-01',
                'fasilitas_nama' => 'Meja Dosen',
                'keterangan' => 'Meja dosen ukuran besar',
                'status' => 'baik',
                'tahun_pengadaan' => '2020',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 4,
                'barang_id' => 14, // Whiteboard
                'fasilitas_kode' => 'BW-R202-01',
                'fasilitas_nama' => 'Whiteboard',
                'keterangan' => 'Whiteboard 2x1 meter',
                'status' => 'baik',
                'tahun_pengadaan' => '2021',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 4,
                'barang_id' => 13, // CCTV
                'fasilitas_kode' => 'CCTV-R202-01',
                'fasilitas_nama' => 'Kamera CCTV',
                'keterangan' => 'Kamera keamanan HD',
                'status' => 'baik',
                'tahun_pengadaan' => '2022',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}