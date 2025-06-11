<?php

namespace Database\Seeders;

use App\Models\RuangModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Sudah ada, tidak perlu diubah

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RuangModel::insert([
            ['lantai_id' => 1, 'ruang_kode' => 'R101', 'ruang_nama' => 'Lab Komputer 1'],
            ['lantai_id' => 1, 'ruang_kode' => 'R102', 'ruang_nama' => 'Lab Komputer 2'],
            ['lantai_id' => 2, 'ruang_kode' => 'R201', 'ruang_nama' => 'Kelas A'],
            ['lantai_id' => 2, 'ruang_kode' => 'R202', 'ruang_nama' => 'Kelas B'],
            // Tambahan data ruang
            ['lantai_id' => 1, 'ruang_kode' => 'R103', 'ruang_nama' => 'Ruang Dosen TI'],
            ['lantai_id' => 1, 'ruang_kode' => 'R104', 'ruang_nama' => 'Ruang Server'],
            ['lantai_id' => 2, 'ruang_kode' => 'R203', 'ruang_nama' => 'Kelas C'],
            ['lantai_id' => 2, 'ruang_kode' => 'R204', 'ruang_nama' => 'Ruang Rapat'],
            ['lantai_id' => 3, 'ruang_kode' => 'R301', 'ruang_nama' => 'Auditorium Mini'],
            ['lantai_id' => 3, 'ruang_kode' => 'R302', 'ruang_nama' => 'Perpustakaan Lantai 3'],
            ['lantai_id' => 3, 'ruang_kode' => 'R303', 'ruang_nama' => 'Ruang Sidang'],
            ['lantai_id' => 4, 'ruang_kode' => 'R401', 'ruang_nama' => 'Lab Fisika'],
            ['lantai_id' => 4, 'ruang_kode' => 'R402', 'ruang_nama' => 'Lab Kimia'],
        ]);
    }
}
