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
        Schema::create('m_bobot_prioritas', function (Blueprint $table) {
            $table->id('bobot_id');
            $table->string('bobot_kode', 10)->unique(); // HIGH, MED, LOW
            $table->string('bobot_nama', 20); // High Priority
            $table->integer('skor_min')->comment('Nilai minimal ');
            $table->integer('skor_max')->comment('Nilai maksimal ');
            $table->text('tindakan')->nullable(); // "Perbaikan <24 jam"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_bobot_prioritas');
    }
};
