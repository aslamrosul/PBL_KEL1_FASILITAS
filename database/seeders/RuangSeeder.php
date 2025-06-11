<?php

namespace Database\Seeders;

use App\Models\RuangModel;
use Illuminate\Database\Seeder;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RuangModel::insert([
            [
                'lantai_id' => 1,
                'ruang_kode' => 'R101',
                'ruang_nama' => 'Lab Komputer 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lantai_id' => 1,
                'ruang_kode' => 'R102',
                'ruang_nama' => 'Lab Komputer 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lantai_id' => 2,
                'ruang_kode' => 'R201',
                'ruang_nama' => 'Kelas A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lantai_id' => 2,
                'ruang_kode' => 'R202',
                'ruang_nama' => 'Kelas B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lantai_id' => 3,
                'ruang_kode' => 'R301',
                'ruang_nama' => 'Ruang Seminar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lantai_id' => 3,
                'ruang_kode' => 'R302',
                'ruang_nama' => 'Lab Fisika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lantai_id' => 4,
                'ruang_kode' => 'R401',
                'ruang_nama' => 'Ruang Dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lantai_id' => 4,
                'ruang_kode' => 'R402',
                'ruang_nama' => 'Perpustakaan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}