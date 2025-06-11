<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GedungSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_gedung')->insert([
            [
                'gedung_kode' => 'GD-ADM',
                'gedung_nama' => 'Gedung Administrasi Niaga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-GRAPOL',
                'gedung_nama' => 'Gedung Graha Polinema (Grapol) gedung kuliah bersama',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-JTS',
                'gedung_nama' => 'Gedung Jurusan Teknik Sipil',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-TM',
                'gedung_nama' => 'Gedung Jurusan Teknik Mesin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-AD-AKT',
                'gedung_nama' => 'Gedung AD jurusan akuntansi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-AE-ADM',
                'gedung_nama' => 'AE jurusan administrasiniaga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-AQ-KIM',
                'gedung_nama' => 'AQ jurusan kimia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-AF-ELK',
                'gedung_nama' => 'AF jurusan elektronika',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-AB-ADM',
                'gedung_nama' => 'AB jurusan administrasiniaga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-AJ-ELK',
                'gedung_nama' => 'AJ jurusan elektronika',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GD-AK-ELK',
                'gedung_nama' => 'AK jurusan elektronika',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}