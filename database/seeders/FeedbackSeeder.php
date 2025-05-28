<?php

namespace Database\Seeders;
use Carbon\Carbon;
use App\Models\FeedbackModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        FeedbackModel::insert([
            [
                'laporan_id' => 1,
                'rating' => 4,
                'komentar' => 'Perbaikan cukup cepat, tapi masih ada sedikit masalah',
                 'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
