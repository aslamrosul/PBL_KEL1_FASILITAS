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
        // database/migrations/2024_03_20_000020_create_periode_table.php
        Schema::create('m_periode', function (Blueprint $table) {
            $table->id('periode_id');
            $table->string('kode_periode', 20)->unique(); // Contoh: 2023-GENAP
            $table->string('nama_periode', 50); // Contoh: Semester Genap 2023/2024
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('is_aktif')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_periode');
    }
};
