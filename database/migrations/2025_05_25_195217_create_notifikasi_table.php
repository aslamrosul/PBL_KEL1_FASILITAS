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
        Schema::create('notifikasi', function (Blueprint $table) {
    $table->id('notifikasi_id');
    $table->string('judul');
    $table->text('pesan');
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('laporan_id')->nullable();
    $table->string('tipe'); // 'laporan', 'perbaikan', 'feedback', dll
    $table->boolean('dibaca')->default(false);
    $table->timestamps();

    $table->foreign('user_id')->references('user_id')->on('m_user');
    $table->foreign('laporan_id')->references('laporan_id')->on('t_laporan');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
