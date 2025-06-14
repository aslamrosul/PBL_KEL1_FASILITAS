<?php

namespace Database\Seeders;

use App\Models\RuangModel;
use Illuminate\Database\Seeder;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        RuangModel::insert([
            // Gedung Sipil (lantai_id 1-8)
            ['lantai_id' => 1, 'ruang_kode' => 'R101', 'ruang_nama' => 'Lab Komputer 1'],
            ['lantai_id' => 1, 'ruang_kode' => 'R102', 'ruang_nama' => 'Lab Komputer 2'],
            ['lantai_id' => 2, 'ruang_kode' => 'R201', 'ruang_nama' => 'Kelas A'],
            ['lantai_id' => 2, 'ruang_kode' => 'R202', 'ruang_nama' => 'Kelas B'],
            ['lantai_id' => 3, 'ruang_kode' => 'R301', 'ruang_nama' => 'Lab Pemrograman 1'],
            ['lantai_id' => 3, 'ruang_kode' => 'R302', 'ruang_nama' => 'Lab Struktur 1'],
            ['lantai_id' => 4, 'ruang_kode' => 'R401', 'ruang_nama' => 'Lab Pemrograman 2'],
            ['lantai_id' => 4, 'ruang_kode' => 'R402', 'ruang_nama' => 'Lab Struktur 2'],
            ['lantai_id' => 5, 'ruang_kode' => 'R501', 'ruang_nama' => 'Ruang Kuliah Sipil 1'],
            ['lantai_id' => 5, 'ruang_kode' => 'R502', 'ruang_nama' => 'Lab Jaringan Komputer'],
            ['lantai_id' => 6, 'ruang_kode' => 'R601', 'ruang_nama' => 'Ruang Kuliah Sipil 2'],
            ['lantai_id' => 6, 'ruang_kode' => 'R602', 'ruang_nama' => 'Lab Basis Data'],
            ['lantai_id' => 7, 'ruang_kode' => 'R701', 'ruang_nama' => 'Ruang Kuliah Sipil 3'],
            ['lantai_id' => 7, 'ruang_kode' => 'R702', 'ruang_nama' => 'Lab Sistem Informasi'],
            ['lantai_id' => 8, 'ruang_kode' => 'R801', 'ruang_nama' => 'Ruang Kuliah Sipil 4'],
            ['lantai_id' => 8, 'ruang_kode' => 'R802', 'ruang_nama' => 'Lab Struktur 3'],

            // Gedung Akuntansi (lantai_id 9-11)
            ['lantai_id' => 9, 'ruang_kode' => 'GAKR101', 'ruang_nama' => 'Lab Komputer Akuntansi 1'],
            ['lantai_id' => 9, 'ruang_kode' => 'GAKR102', 'ruang_nama' => 'Kelas Akuntansi 1'],
            ['lantai_id' => 10, 'ruang_kode' => 'GAKR201', 'ruang_nama' => 'Lab Komputer Akuntansi 2'],
            ['lantai_id' => 10, 'ruang_kode' => 'GAKR202', 'ruang_nama' => 'Kelas Akuntansi 2'],
            ['lantai_id' => 11, 'ruang_kode' => 'GAKR301', 'ruang_nama' => 'Lab Komputer Akuntansi 3'],
            ['lantai_id' => 11, 'ruang_kode' => 'GAKR302', 'ruang_nama' => 'Kelas Akuntansi 3'],

            // Gedung Mesin (lantai_id 12-16)
            ['lantai_id' => 12, 'ruang_kode' => 'GMSR101', 'ruang_nama' => 'Lab Mesin 1'],
            ['lantai_id' => 12, 'ruang_kode' => 'GMSR102', 'ruang_nama' => 'Workshop Mesin 1'],
            ['lantai_id' => 13, 'ruang_kode' => 'GMSR201', 'ruang_nama' => 'Lab Mesin 2'],
            ['lantai_id' => 13, 'ruang_kode' => 'GMSR202', 'ruang_nama' => 'Workshop Mesin 2'],
            ['lantai_id' => 14, 'ruang_kode' => 'GMSR301', 'ruang_nama' => 'Lab Mesin 3'],
            ['lantai_id' => 14, 'ruang_kode' => 'GMSR302', 'ruang_nama' => 'Workshop Mesin 3'],
            ['lantai_id' => 15, 'ruang_kode' => 'GMSR401', 'ruang_nama' => 'Lab Mesin 4'],
            ['lantai_id' => 15, 'ruang_kode' => 'GMSR402', 'ruang_nama' => 'Workshop Mesin 4'],
            ['lantai_id' => 16, 'ruang_kode' => 'GMSR501', 'ruang_nama' => 'Lab Mesin 5'],
            ['lantai_id' => 16, 'ruang_kode' => 'GMSR502', 'ruang_nama' => 'Workshop Mesin 5'],

            // Gedung Administrasi Niaga (lantai_id 17-20)
            ['lantai_id' => 17, 'ruang_kode' => 'GANR101', 'ruang_nama' => 'Kelas Administrasi 1'],
            ['lantai_id' => 17, 'ruang_kode' => 'GANR102', 'ruang_nama' => 'Ruang Seminar 1'],
            ['lantai_id' => 18, 'ruang_kode' => 'GANR201', 'ruang_nama' => 'Kelas Administrasi 2'],
            ['lantai_id' => 18, 'ruang_kode' => 'GANR202', 'ruang_nama' => 'Ruang Seminar 2'],
            ['lantai_id' => 19, 'ruang_kode' => 'GANR301', 'ruang_nama' => 'Kelas Administrasi 3'],
            ['lantai_id' => 19, 'ruang_kode' => 'GANR302', 'ruang_nama' => 'Ruang Seminar 3'],
            ['lantai_id' => 20, 'ruang_kode' => 'GANR401', 'ruang_nama' => 'Kelas Administrasi 4'],
            ['lantai_id' => 20, 'ruang_kode' => 'GANR402', 'ruang_nama' => 'Ruang Seminar 4'],

            // Gedung Kimia (lantai_id 21-23)
            ['lantai_id' => 21, 'ruang_kode' => 'GKMR101', 'ruang_nama' => 'Lab Kimia 1'],
            ['lantai_id' => 21, 'ruang_kode' => 'GKMR102', 'ruang_nama' => 'Ruang Kuliah Kimia 1'],
            ['lantai_id' => 22, 'ruang_kode' => 'GKMR201', 'ruang_nama' => 'Lab Kimia 2'],
            ['lantai_id' => 22, 'ruang_kode' => 'GKMR202', 'ruang_nama' => 'Ruang Kuliah Kimia 2'],
            ['lantai_id' => 23, 'ruang_kode' => 'GKMR301', 'ruang_nama' => 'Lab Kimia 3'],
            ['lantai_id' => 23, 'ruang_kode' => 'GKMR302', 'ruang_nama' => 'Ruang Kuliah Kimia 3'],

            // Gedung Elektronika (lantai_id 24-27)
            ['lantai_id' => 24, 'ruang_kode' => 'GEKR101', 'ruang_nama' => 'Lab Elektronika 1'],
            ['lantai_id' => 24, 'ruang_kode' => 'GEKR102', 'ruang_nama' => 'Kelas Elektronika 1'],
            ['lantai_id' => 25, 'ruang_kode' => 'GEKR201', 'ruang_nama' => 'Lab Elektronika 2'],
            ['lantai_id' => 25, 'ruang_kode' => 'GEKR202', 'ruang_nama' => 'Kelas Elektronika 2'],
            ['lantai_id' => 26, 'ruang_kode' => 'GEKR301', 'ruang_nama' => 'Lab Elektronika 3'],
            ['lantai_id' => 26, 'ruang_kode' => 'GEKR302', 'ruang_nama' => 'Kelas Elektronika 3'],
            ['lantai_id' => 27, 'ruang_kode' => 'GEKR401', 'ruang_nama' => 'Lab Elektronika 4'],
            ['lantai_id' => 27, 'ruang_kode' => 'GEKR402', 'ruang_nama' => 'Kelas Elektronika 4'],
        ]);
    }
}