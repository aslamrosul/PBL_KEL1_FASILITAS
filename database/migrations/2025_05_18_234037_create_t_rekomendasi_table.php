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
            $table->unsignedBigInteger(column: 'laporan_id');
            $table->json('rekom_mahasiswa')->nullable(); // {skor: 85, kriteria: {...}}
            $table->json('rekom_dosen')->nullable();
            $table->json('rekom_tendik')->nullable();
            $table->decimal('skor_final', 8, 2);
            $table->unsignedBigInteger(column: 'bobot_id');
            $table->timestamps();

            $table->foreign(columns: 'laporan_id')->references(columns: 'laporan_id')->on('t_laporan')->onDelete('cascade');
            $table->foreign(columns: 'bobot_id')->references(columns: 'bobot_id')->on('m_bobot_prioritas')->onDelete('restrict');
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
