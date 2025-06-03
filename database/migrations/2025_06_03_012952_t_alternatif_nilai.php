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
        Schema::create('t_alternatif_nilai', function (Blueprint $table) {
            $table->id('alternatif_id');
            $table->unsignedBigInteger('fasilitas_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->float('nilai', 8, 2);
            $table->unsignedBigInteger('periode_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('m_fasilitas')->onDelete('cascade');

            $table->foreign('kriteria_id')->references('kriteria_id')->on('m_kriteria_gdss')->onDelete('cascade');

            $table->foreign('periode_id')->references('periode_id')->on('m_periode')->onDelete('set null');

            // Composite unique constraint
            $table->unique(['fasilitas_id', 'kriteria_id', 'periode_id'], 'alternatif_nilai_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_alternatif_nilai');
    }
};
