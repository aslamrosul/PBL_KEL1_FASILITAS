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
                'gedung_kode' => 'GDG-SPL',
                'gedung_nama' => 'Gedung Sipil',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-AKT',
                'gedung_nama' => 'Gedung Akuntansi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-MSN',
                'gedung_nama' => 'Gedung Mesin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gedung_kode' => 'GDG-ADM',
                'gedung_nama' => 'Gedung Administrasi Niaga',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
