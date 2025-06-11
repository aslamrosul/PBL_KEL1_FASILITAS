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
            // Lab Komputer 1 (R101, ruang_id 1)
            ['ruang_id' => 1, 'barang_id' => 1, 'fasilitas_kode' => 'PC-R101-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i5, 8GB RAM, 256GB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 1, 'barang_id' => 6, 'fasilitas_kode' => 'MON-R101-01', 'fasilitas_nama' => 'Monitor 24"', 'keterangan' => 'Monitor LED 24 inch', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 1, 'barang_id' => 2, 'fasilitas_kode' => 'PRJ-R101-01', 'fasilitas_nama' => 'Proyektor Epson', 'keterangan' => 'Proyektor 3600 lumens', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 1, 'barang_id' => 3, 'fasilitas_kode' => 'SCR-R101-01', 'fasilitas_nama' => 'Layar Proyektor', 'keterangan' => 'Layar 120 inch', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Komputer 2 (R102, ruang_id 2)
            ['ruang_id' => 2, 'barang_id' => 1, 'fasilitas_kode' => 'PC-R102-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i5, 8GB RAM, 512GB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 2, 'barang_id' => 5, 'fasilitas_kode' => 'ACSP-R102-01', 'fasilitas_nama' => 'AC Split 1', 'keterangan' => 'AC Daikin 1 PK', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 2, 'barang_id' => 12, 'fasilitas_kode' => 'WIFI-R102-01', 'fasilitas_nama' => 'Access Point WiFi', 'keterangan' => 'TP-Link EAP245', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 2, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-R102-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas A (R201, ruang_id 3)
            ['ruang_id' => 3, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-R201-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 3, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-R201-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 3, 'barang_id' => 14, 'fasilitas_kode' => 'BW-R201-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas B (R202, ruang_id 4)
            ['ruang_id' => 4, 'barang_id' => 9, 'fasilitas_kode' => 'MJDS-R202-01', 'fasilitas_nama' => 'Meja Dosen', 'keterangan' => 'Meja dosen ukuran besar', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 4, 'barang_id' => 14, 'fasilitas_kode' => 'BW-R202-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 4, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-R202-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Pemrograman 1 (R301, ruang_id 5)
            ['ruang_id' => 5, 'barang_id' => 1, 'fasilitas_kode' => 'PC-R301-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i7, 16GB RAM, 512GB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 5, 'barang_id' => 6, 'fasilitas_kode' => 'MON-R301-01', 'fasilitas_nama' => 'Monitor 27"', 'keterangan' => 'Monitor LED 27 inch', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 5, 'barang_id' => 5, 'fasilitas_kode' => 'ACSP-R301-01', 'fasilitas_nama' => 'AC Split 1', 'keterangan' => 'AC Panasonic 1.5 PK', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 5, 'barang_id' => 12, 'fasilitas_kode' => 'WIFI-R301-01', 'fasilitas_nama' => 'Access Point WiFi', 'keterangan' => 'TP-Link EAP265 HD', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Struktur 1 (R302, ruang_id 6)
            ['ruang_id' => 6, 'barang_id' => 14, 'fasilitas_kode' => 'BW-R302-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 6, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-R302-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Pemrograman 2 (R401, ruang_id 7)
            ['ruang_id' => 7, 'barang_id' => 1, 'fasilitas_kode' => 'PC-R401-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i7, 16GB RAM, 1TB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 7, 'barang_id' => 6, 'fasilitas_kode' => 'MON-R401-01', 'fasilitas_nama' => 'Monitor 27"', 'keterangan' => 'Monitor LED 27 inch', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 7, 'barang_id' => 2, 'fasilitas_kode' => 'PRJ-R401-01', 'fasilitas_nama' => 'Proyektor BenQ', 'keterangan' => 'Proyektor 4000 lumens', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 7, 'barang_id' => 3, 'fasilitas_kode' => 'SCR-R401-01', 'fasilitas_nama' => 'Layar Proyektor', 'keterangan' => 'Layar 120 inch', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Struktur 2 (R402, ruang_id 8)
            ['ruang_id' => 8, 'barang_id' => 14, 'fasilitas_kode' => 'BW-R402-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 8, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-R402-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Kuliah Sipil 1 (R501, ruang_id 9)
            ['ruang_id' => 9, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-R501-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (40 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 9, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-R501-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (20 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 9, 'barang_id' => 9, 'fasilitas_kode' => 'MJDS-R501-01', 'fasilitas_nama' => 'Meja Dosen', 'keterangan' => 'Meja dosen ukuran besar', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Jaringan Komputer (R502, ruang_id 10)
            ['ruang_id' => 10, 'barang_id' => 1, 'fasilitas_kode' => 'PC-R502-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i5, 16GB RAM, 512GB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 10, 'barang_id' => 12, 'fasilitas_kode' => 'WIFI-R502-01', 'fasilitas_nama' => 'Access Point WiFi', 'keterangan' => 'Cisco Meraki MR33', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 10, 'barang_id' => 5, 'fasilitas_kode' => 'ACSP-R502-01', 'fasilitas_nama' => 'AC Split 1', 'keterangan' => 'AC LG 1 PK', 'status' => 'rusak', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Kuliah Sipil 2 (R601, ruang_id 11)
            ['ruang_id' => 11, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-R601-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (40 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 11, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-R601-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (20 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 11, 'barang_id' => 14, 'fasilitas_kode' => 'BW-R601-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Basis Data (R602, ruang_id 12)
            ['ruang_id' => 12, 'barang_id' => 1, 'fasilitas_kode' => 'PC-R602-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i7, 16GB RAM, 1TB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 12, 'barang_id' => 6, 'fasilitas_kode' => 'MON-R602-01', 'fasilitas_nama' => 'Monitor 27"', 'keterangan' => 'Monitor LED 27 inch', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 12, 'barang_id' => 12, 'fasilitas_kode' => 'WIFI-R602-01', 'fasilitas_nama' => 'Access Point WiFi', 'keterangan' => 'TP-Link EAP265 HD', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Kuliah Sipil 3 (R701, ruang_id 13)
            ['ruang_id' => 13, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-R701-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (40 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 13, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-R701-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (20 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 13, 'barang_id' => 9, 'fasilitas_kode' => 'MJDS-R701-01', 'fasilitas_nama' => 'Meja Dosen', 'keterangan' => 'Meja dosen ukuran besar', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Sistem Informasi (R702, ruang_id 14)
            ['ruang_id' => 14, 'barang_id' => 1, 'fasilitas_kode' => 'PC-R702-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i5, 16GB RAM, 512GB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 14, 'barang_id' => 6, 'fasilitas_kode' => 'MON-R702-01', 'fasilitas_nama' => 'Monitor 24"', 'keterangan' => 'Monitor LED 24 inch', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 14, 'barang_id' => 5, 'fasilitas_kode' => 'ACSP-R702-01', 'fasilitas_nama' => 'AC Split 1', 'keterangan' => 'AC Samsung 1 PK', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Kuliah Sipil 4 (R801, ruang_id 15)
            ['ruang_id' => 15, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-R801-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (40 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 15, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-R801-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (20 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 15, 'barang_id' => 14, 'fasilitas_kode' => 'BW-R801-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'rusak', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Struktur 3 (R802, ruang_id 16)
            ['ruang_id' => 16, 'barang_id' => 14, 'fasilitas_kode' => 'BW-R802-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 16, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-R802-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Komputer Akuntansi 1 (GAKR101, ruang_id 17)
            ['ruang_id' => 17, 'barang_id' => 1, 'fasilitas_kode' => 'PC-GAKR101-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i5, 8GB RAM, 256GB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 17, 'barang_id' => 6, 'fasilitas_kode' => 'MON-GAKR101-01', 'fasilitas_nama' => 'Monitor 24"', 'keterangan' => 'Monitor LED 24 inch', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 17, 'barang_id' => 5, 'fasilitas_kode' => 'ACSP-GAKR101-01', 'fasilitas_nama' => 'AC Split 1', 'keterangan' => 'AC Daikin 1 PK', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Akuntansi 1 (GAKR102, ruang_id 18)
            ['ruang_id' => 18, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GAKR102-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 18, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GAKR102-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Komputer Akuntansi 2 (GAKR201, ruang_id 19)
            ['ruang_id' => 19, 'barang_id' => 1, 'fasilitas_kode' => 'PC-GAKR201-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i5, 8GB RAM, 512GB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 19, 'barang_id' => 6, 'fasilitas_kode' => 'MON-GAKR201-01', 'fasilitas_nama' => 'Monitor 24"', 'keterangan' => 'Monitor LED 24 inch', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 19, 'barang_id' => 12, 'fasilitas_kode' => 'WIFI-GAKR201-01', 'fasilitas_nama' => 'Access Point WiFi', 'keterangan' => 'TP-Link EAP245', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Akuntansi 2 (GAKR202, ruang_id 20)
            ['ruang_id' => 20, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GAKR202-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 20, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GAKR202-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Komputer Akuntansi 3 (GAKR301, ruang_id 21)
            ['ruang_id' => 21, 'barang_id' => 1, 'fasilitas_kode' => 'PC-GAKR301-01', 'fasilitas_nama' => 'Komputer Desktop 1', 'keterangan' => 'PC Intel Core i7, 16GB RAM, 512GB SSD', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 21, 'barang_id' => 6, 'fasilitas_kode' => 'MON-GAKR301-01', 'fasilitas_nama' => 'Monitor 27"', 'keterangan' => 'Monitor LED 27 inch', 'status' => 'baik', 'tahun_pengadaan' => '2023', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 21, 'barang_id' => 5, 'fasilitas_kode' => 'ACSP-GAKR301-01', 'fasilitas_nama' => 'AC Split 1', 'keterangan' => 'AC Panasonic 1.5 PK', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Akuntansi 3 (GAKR302, ruang_id 22)
            ['ruang_id' => 22, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GAKR302-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 22, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GAKR302-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Mesin 1 (GMSR101, ruang_id 23)
            ['ruang_id' => 23, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR101-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 23, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR101-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 23, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-GMSR101-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Workshop Mesin 1 (GMSR102, ruang_id 24)
            ['ruang_id' => 24, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR102-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 24, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR102-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Mesin 2 (GMSR201, ruang_id 25)
            ['ruang_id' => 25, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR201-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 25, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR201-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 25, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-GMSR201-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Workshop Mesin 2 (GMSR202, ruang_id 26)
            ['ruang_id' => 26, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR202-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 26, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR202-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Mesin 3 (GMSR301, ruang_id 27)
            ['ruang_id' => 27, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR301-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 27, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR301-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Workshop Mesin 3 (GMSR302, ruang_id 28)
            ['ruang_id' => 28, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR302-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 28, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR302-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Mesin 4 (GMSR401, ruang_id 29)
            ['ruang_id' => 29, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR401-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 29, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR401-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Workshop Mesin 4 (GMSR402, ruang_id 30)
            ['ruang_id' => 30, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR402-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 30, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR402-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Mesin 5 (GMSR501, ruang_id 31)
            ['ruang_id' => 31, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR501-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 31, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR501-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Workshop Mesin 5 (GMSR502, ruang_id 32)
            ['ruang_id' => 32, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GMSR502-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 32, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GMSR502-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Administrasi 1 (GANR101, ruang_id 33)
            ['ruang_id' => 33, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GANR101-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 33, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GANR101-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Seminar 1 (GANR102, ruang_id 34)
            ['ruang_id' => 34, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GANR102-01', 'fasilitas_nama' => 'Kursi Seminar', 'keterangan' => 'Set kursi seminar (20 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 34, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GANR102-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Administrasi 2 (GANR201, ruang_id 35)
            ['ruang_id' => 35, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GANR201-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 35, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GANR201-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Seminar 2 (GANR202, ruang_id 36)
            ['ruang_id' => 36, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GANR202-01', 'fasilitas_nama' => 'Kursi Seminar', 'keterangan' => 'Set kursi seminar (20 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 36, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GANR202-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Administrasi 3 (GANR301, ruang_id 37)
            ['ruang_id' => 37, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GANR301-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 37, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GANR301-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Seminar 3 (GANR302, ruang_id 38)
            ['ruang_id' => 38, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GANR302-01', 'fasilitas_nama' => 'Kursi Seminar', 'keterangan' => 'Set kursi seminar (20 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 38, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GANR302-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Administrasi 4 (GANR401, ruang_id 39)
            ['ruang_id' => 39, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GANR401-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 39, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GANR401-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Seminar 4 (GANR402, ruang_id 40)
            ['ruang_id' => 40, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GANR402-01', 'fasilitas_nama' => 'Kursi Seminar', 'keterangan' => 'Set kursi seminar (20 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 40, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GANR402-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1 meter', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Kimia 1 (GKMR101, ruang_id 41)
            ['ruang_id' => 41, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GKMR101-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 41, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GKMR101-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 41, 'barang_id' => 16, 'fasilitas_kode' => 'KOTAK-GKMR101-01', 'fasilitas_nama' => 'Kotak P3K', 'keterangan' => 'Kotak pertolongan pertama', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Kuliah Kimia 1 (GKMR102, ruang_id 42)
            ['ruang_id' => 42, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GKMR102-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 42, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GKMR102-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Kimia 2 (GKMR201, ruang_id 43)
            ['ruang_id' => 43, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GKMR201-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 43, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GKMR201-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Kuliah Kimia 2 (GKMR202, ruang_id 44)
            ['ruang_id' => 44, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GKMR202-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 44, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GKMR202-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Kimia 3 (GKMR301, ruang_id 45)
            ['ruang_id' => 45, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GKMR301-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 45, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GKMR301-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Ruang Kuliah Kimia 3 (GKMR302, ruang_id 46)
            ['ruang_id' => 46, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GKMR302-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 46, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GKMR302-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Elektronika 1 (GEKR101, ruang_id 47)
            ['ruang_id' => 47, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GEKR101-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 47, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GEKR101-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 47, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-GEKR101-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Elektronika 1 (GEKR102, ruang_id 48)
            ['ruang_id' => 48, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GEKR102-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 48, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GEKR102-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Elektronika 2 (GEKR201, ruang_id 49)
            ['ruang_id' => 49, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GEKR201-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 49, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GEKR201-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 49, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-GEKR201-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Elektronika 2 (GEKR202, ruang_id 50)
            ['ruang_id' => 50, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GEKR202-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 50, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GEKR202-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Elektronika 3 (GEKR301, ruang_id 51)
            ['ruang_id' => 51, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GEKR301-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 51, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GEKR301-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 51, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-GEKR301-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Elektronika 3 (GEKR302, ruang_id 52)
            ['ruang_id' => 52, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GEKR302-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 52, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GEKR302-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Lab Elektronika 4 (GEKR401, ruang_id 53)
            ['ruang_id' => 53, 'barang_id' => 14, 'fasilitas_kode' => 'BW-GEKR401-01', 'fasilitas_nama' => 'Whiteboard', 'keterangan' => 'Whiteboard 2x1.5 meter', 'status' => 'baik', 'tahun_pengadaan' => '2020', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 53, 'barang_id' => 17, 'fasilitas_kode' => 'ALARM-GEKR401-01', 'fasilitas_nama' => 'Alarm Kebakaran', 'keterangan' => 'Alarm kebakaran otomatis', 'status' => 'baik', 'tahun_pengadaan' => '2021', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 53, 'barang_id' => 13, 'fasilitas_kode' => 'CCTV-GEKR401-01', 'fasilitas_nama' => 'Kamera CCTV', 'keterangan' => 'Kamera keamanan HD', 'status' => 'baik', 'tahun_pengadaan' => '2022', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Kelas Elektronika 4 (GEKR402, ruang_id 54)
            ['ruang_id' => 54, 'barang_id' => 7, 'fasilitas_kode' => 'KRS-GEKR402-01', 'fasilitas_nama' => 'Kursi Kuliah', 'keterangan' => 'Set kursi kuliah (30 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['ruang_id' => 54, 'barang_id' => 8, 'fasilitas_kode' => 'MJA-GEKR402-01', 'fasilitas_nama' => 'Meja Kuliah', 'keterangan' => 'Set meja kuliah (15 unit)', 'status' => 'baik', 'tahun_pengadaan' => '2019', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}