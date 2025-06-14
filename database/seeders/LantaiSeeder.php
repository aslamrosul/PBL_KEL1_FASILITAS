<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LantaiSeeder extends Seeder
{
    public function run(): void
    {
        $gedungs = DB::table('m_gedung')->get()->keyBy('gedung_kode');

        $lantaiData = [];

        // Gedung Sipil - 8 Lantai
        for ($i = 1; $i <= 8; $i++) {
            $lantaiData[] = [
                'lantai_nomor' => "Lantai $i",
                'gedung_id' => $gedungs['GDG-SPL']->gedung_id ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Gedung Akuntansi - 3 Lantai
        for ($i = 1; $i <= 3; $i++) {
            $lantaiData[] = [
                'lantai_nomor' => "Lantai $i",
                'gedung_id' => $gedungs['GDG-AKT']->gedung_id ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Gedung Mesin - 5 Lantai
        for ($i = 1; $i <= 5; $i++) {
            $lantaiData[] = [
                'lantai_nomor' => "Lantai $i",
                'gedung_id' => $gedungs['GDG-MSN']->gedung_id ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Gedung Administrasi Niaga - 4 Lantai
        for ($i = 1; $i <= 4; $i++) {
            $lantaiData[] = [
                'lantai_nomor' => "Lantai $i",
                'gedung_id' => $gedungs['GDG-ADM']->gedung_id ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Gedung Kimia - 3 Lantai (added)
        for ($i = 1; $i <= 3; $i++) {
            $lantaiData[] = [
                'lantai_nomor' => "Lantai $i",
                'gedung_id' => $gedungs['GDG-KMA']->gedung_id ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Gedung Elektronika - 4 Lantai (added)
        for ($i = 1; $i <= 4; $i++) {
            $lantaiData[] = [
                'lantai_nomor' => "Lantai $i",
                'gedung_id' => $gedungs['GDG-ELK']->gedung_id ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Filter data yang punya gedung_id valid
        $lantaiData = array_filter($lantaiData, fn($item) => $item['gedung_id'] !== null);

        DB::table('m_lantai')->insert($lantaiData);
    }
}