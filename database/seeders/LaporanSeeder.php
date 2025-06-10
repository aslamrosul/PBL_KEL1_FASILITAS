<?php

namespace Database\Seeders;

use App\Models\LaporanModel;
use Carbon\Carbon;

use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run()
    {
        LaporanModel::insert([
            [
                'user_id' => 2,
                'periode_id' => 1,
                'fasilitas_id' => 1,
                'judul' => 'Komputer Tidak Menyala',
                'deskripsi' => 'Komputer di Lab 1 tidak bisa menyala ketika dinyalakan',
                'foto_path' => null,
                'bobot_id' => 1,
                'status' => 'menunggu', //e, diterima, diproses, ditolak, selesai
                'alasan_penolakan' => null,
                'tanggal_selesai' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'user_id' => 3,
                'periode_id' => 1,
                'fasilitas_id' => 2,
                'judul' => 'Proyektor Berkedip',
                'deskripsi' => 'Proyektor di Lab 1 sering berkedip ketika digunakan',
                'foto_path' => null,
                'bobot_id' => null,
                'status' => 'menunggu', //e, diterima, diproses, ditolak, selesai
                'alasan_penolakan' => null,
                'tanggal_selesai' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'periode_id' => 1,
                'fasilitas_id' => 2,
                'judul' => 'Proyektor Tidak Menyala',
                'deskripsi' => 'Proyektor di Lab 1 tidak bisa menyala ketika dinyalakan',
                'foto_path' => null,
                'bobot_id' => 1,
                'status' => 'selesai',
                'alasan_penolakan' => null,
                'tanggal_selesai' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'user_id' => 2,
                'periode_id' => 1,
                'fasilitas_id' => 4,
                'judul' => 'AC Tidak Menyala',
                'deskripsi' => 'AC di Lab 1 tidak bisa menyala ketika dinyalakan',
                'foto_path' => null,
                'bobot_id' => 1,
                'status' => 'diterima', //menunggu', //e, diterima, diproses, ditolak, selesai
                'alasan_penolakan' => null,
                'tanggal_selesai' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
