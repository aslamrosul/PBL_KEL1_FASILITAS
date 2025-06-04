<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_kriteria', function (Blueprint $table) {
            $table->id('kriteria_id');
            $table->string('kriteria_kode', 20)->unique();
            $table->string('kriteria_nama', 100)->comment('Dampak Akademik, Jumlah Pengguna, dll');
            $table->decimal('bobot', 3, 2)->comment('Bobot kriteria 0-1');
            $table->enum('kriteria_jenis', ['benefit', 'cost'])->default('benefit')->comment('Jenis kriteria: benefit atau cost');
            $table->timestamps();
        });

        // database/migrations/2024_03_20_000015_create_student_recommendations_table.php

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kriteria');
    }
};
