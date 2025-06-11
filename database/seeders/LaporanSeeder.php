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
                'user_id' => 5, // Mahasiswa: Ahmad Fauzi
                'periode_id' => 1,
                'fasilitas_id' => 1,
                'judul' => 'Komputer Tidak Menyala',
                'deskripsi' => 'Komputer di Lab 1 tidak bisa menyala ketika dinyalakan',
                'foto_path' => null,
                'bobot_id' => null,
                'status' => 'selesai',
                'alasan_penolakan' => null,
                'tanggal_selesai' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 6, // Mahasiswa: Dewi Lestari
                'periode_id' => 1,
                'fasilitas_id' => 3,
                'judul' => 'Kursi Rusak di Ruang Kuliah',
                'deskripsi' => 'Kursi di ruang kuliah A-101 patah pada bagian sandaran',
                'foto_path' => null,
                'bobot_id' => null,
                'status' => 'diterima',
                'alasan_penolakan' => null,
                'tanggal_selesai' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 17, // Dosen: Dr. Bambang Suharto
                'periode_id' => 1,
                'fasilitas_id' => 2,
                'judul' => 'Proyektor Tidak Menyala',
                'deskripsi' => 'Proyektor di ruang seminar B-203 tidak menyala saat digunakan untuk kuliah',
                'foto_path' => null,
                'bobot_id' => null,
                'status' => 'selesai',
                'alasan_penolakan' => null,
                'tanggal_selesai' => Carbon::now(),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 18, // Dosen: Dr. Ani Rahmawati
                'periode_id' => 1,
                'fasilitas_id' => 3,
                'judul' => 'AC Mengeluarkan Suara Berisik',
                'deskripsi' => 'AC di ruang dosen lantai 2 mengeluarkan suara berisik saat dinyalakan',
                'foto_path' => null,
                'bobot_id' => null,
                'status' => 'diproses',
                'alasan_penolakan' => null,
                'tanggal_selesai' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 7, // Mahasiswa: Rizki Pratama
                'periode_id' => 1,
                'fasilitas_id' => 3,
                'judul' => 'Lampu Mati di Lab Komputer',
                'deskripsi' => 'Beberapa lampu di Lab Komputer 2 tidak menyala, membuat ruangan kurang terang',
                'foto_path' => null,
                'bobot_id' => null,
                'status' => 'menunggu',
                'alasan_penolakan' => null,
                'tanggal_selesai' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 19, // Dosen: Dr. Joko Widodo
                'periode_id' => 1,
                'fasilitas_id' => 3,
                'judul' => 'Papan Tulis Rusak',
                'deskripsi' => 'Papan tulis di ruang kuliah C-104 sulit dihapus dan permukaannya rusak',
                'foto_path' => null,
                'bobot_id' => null,
                'status' => 'selesai',
                'alasan_penolakan' => 'Kerusakan dianggap minor dan tidak memerlukan perbaikan segera',
                'tanggal_selesai' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}