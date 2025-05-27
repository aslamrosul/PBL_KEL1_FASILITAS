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
        Schema::create('m_klasifikasi', function (Blueprint $table) {
            $table->id('klasifikasi_id');
            $table->string('klasifikasi_kode', 10);
            $table->string('klasifikasi_nama', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_klasifikasi');
    }
};
