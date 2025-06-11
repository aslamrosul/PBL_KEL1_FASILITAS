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
        Schema::create('m_ruang', function (Blueprint $table) {
            $table->id('ruang_id');
            $table->unsignedBigInteger('lantai_id');
            $table->string('ruang_kode', 10);
            $table->string('ruang_nama', 100);
            $table->timestamps();

            $table->foreign('lantai_id')->references('lantai_id')->on('m_lantai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_ruang');
    }
};
