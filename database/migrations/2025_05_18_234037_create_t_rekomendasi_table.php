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
        Schema::create('t_rekomendasi', function (Blueprint $table) {
            $table->id('rekomendasi_id');
            $table->unsignedBigInteger('laporan_id');
            $table->json('nilai_kriteria')->nullable(); // Kriteria dan nilai perhitungan
            $table->decimal('skor_total', 8, 4)->nullable(); // Skor akhir
            $table->unsignedBigInteger('bobot_id'); // Prioritas
            $table->timestamps();

            $table->foreign('laporan_id')->references('laporan_id')->on('t_laporan')->onDelete('cascade');
            $table->foreign('bobot_id')->references('bobot_id')->on('m_bobot_prioritas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_rekomendasi');
    }
};
