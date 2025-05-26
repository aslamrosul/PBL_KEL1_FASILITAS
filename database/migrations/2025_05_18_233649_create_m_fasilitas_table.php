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
        Schema::create('m_fasilitas', function (Blueprint $table) {
            $table->id('fasilitas_id');
            $table->unsignedBigInteger('ruang_id');
            $table->unsignedBigInteger('barang_id');
            $table->string('fasilitas_kode', 20)->unique();
            $table->string('fasilitas_nama', 100);
            $table->text('keterangan')->nullable();
            $table->string('status', 20)->default('baik')->comment('baik, rusak_ringan, rusak_berat');
            $table->year('tahun_pengadaan')->nullable();
            $table->timestamps();

            $table->foreign('ruang_id')->references('ruang_id')->on('m_ruang')->onDelete('cascade');
            $table->foreign('barang_id')->references('barang_id')->on('m_barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_fasilitas');
    }
};
