<?php

namespace Database\Seeders;

use App\Models\RuangModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run()
    {
        RuangModel::insert([
            ['lantai_id' => 1, 'ruang_kode' => 'R101', 'ruang_nama' => 'Lab Komputer 1'],
            ['lantai_id' => 1, 'ruang_kode' => 'R102', 'ruang_nama' => 'Lab Komputer 2'],
            ['lantai_id' => 2, 'ruang_kode' => 'R201', 'ruang_nama' => 'Kelas A'],
            ['lantai_id' => 2, 'ruang_kode' => 'R202', 'ruang_nama' => 'Kelas B'],
        ]);
    }
}
