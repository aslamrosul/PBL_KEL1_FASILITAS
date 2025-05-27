<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
             LevelSeeder::class,
            UserSeeder::class,
            GedungSeeder::class,
            LantaiSeeder::class,
            RuangSeeder::class,
            KategoriSeeder::class,
            BarangSeeder::class,
            FasilitasSeeder::class,
            KlasifikasiSeeder::class,
            PeriodeSeeder::class,
            BobotPrioritasSeeder::class,
            LaporanSeeder::class,
            LaporanHistorySeeder::class,
            PerbaikanSeeder::class,
            PerbaikanDetailSeeder::class,
            FeedbackSeeder::class,
            KriteriaSeeder::class,
            RekomendasiMahasiswaSeeder::class,
            RekomendasiDosenSeeder::class,
            RekomendasiTendikSeeder::class,
            RekomendasiGDSSSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
