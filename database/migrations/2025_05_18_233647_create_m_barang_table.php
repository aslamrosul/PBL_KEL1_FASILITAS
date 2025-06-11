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
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('klasifikasi_id');
            $table->string('barang_kode', 10);
            $table->string('barang_nama', 100);
            $table->decimal('bobot_prioritas', 4, 2)->default(0.0);
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori')->onDelete('cascade');
            $table->foreign('klasifikasi_id')->references('klasifikasi_id')->on('m_klasifikasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};
