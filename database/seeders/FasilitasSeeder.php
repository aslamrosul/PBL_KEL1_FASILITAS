<?php

namespace Database\Seeders;
use Carbon\Carbon;
use App\Models\FasilitasModel;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        FasilitasModel::insert([
            [
                'ruang_id' => 1,
                'barang_id' => 1,
                'fasilitas_kode' => 'PC-R101-01',
                'fasilitas_nama' => 'Komputer 1 Lab 1',
                'keterangan' => 'PC Intel Core i5',
                'status' => 'baik',
                'tahun_pengadaan' => '2020',
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 1,
                'barang_id' => 2,
                'fasilitas_kode' => 'PRJ-R101-01',
                'fasilitas_nama' => 'Proyektor Lab 1',
                'keterangan' => 'Proyektor Epson',
                'status' => 'baik',
                'tahun_pengadaan' => '2021',
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ruang_id' => 3,
                'barang_id' => 4,
                'fasilitas_kode' => 'WIFI-R201-01',
                'fasilitas_nama' => 'Access Point Kelas A',
                'keterangan' => 'TP-Link EAP245',
                'status' => 'baik',
                'tahun_pengadaan' => '2022',
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
