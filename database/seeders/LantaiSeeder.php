<?php

namespace Database\Seeders;

use App\Models\LantaiModel;
use Illuminate\Database\Seeder;

class LantaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LantaiModel::insert([
            [
                'gedung_id' => 1,
                'lantai_nomor' => 'Lantai 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gedung_id' => 1,
                'lantai_nomor' => 'Lantai 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gedung_id' => 2,
                'lantai_nomor' => 'Lantai 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'gedung_id' => 2,
                'lantai_nomor' => 'Lantai 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}