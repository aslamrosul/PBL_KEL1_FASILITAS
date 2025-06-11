<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GedungSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_gedung')->insert([
            [
                'gedung_kode' => 'GDG-ADM',
                'gedung_nama' => 'Gedung Administrasi Niaga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-GRAPOL',
                'gedung_nama' => 'Gedung Graha Polinema (Grapol) gedung kuliah bersama',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-JTS',
                'gedung_nama' => 'Gedung Jurusan Teknik Sipil',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-TM',
                'gedung_nama' => 'Gedung Jurusan Teknik Mesin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-AD-AKT',
                'gedung_nama' => 'Gedung AD jurusan akuntansi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-AE-ADM',
                'gedung_nama' => 'AE jurusan administrasiniaga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-AQ-KIM',
                'gedung_nama' => 'AQ jurusan kimia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-AF-ELEK',
                'gedung_nama' => 'AF jurusan elektronika',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-AB-ADM',
                'gedung_nama' => 'AB jurusan administrasiniaga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-AJ-ELEK',
                'gedung_nama' => 'AJ jurusan elektronika',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-AK-ELEK',
                'gedung_nama' => 'AK jurusan elektronika',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}