<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('t_riwayat_penugasan', function (Blueprint $table) {
            $table->id('riwayat_penugasan_id');
            $table->unsignedBigInteger('laporan_id');
            $table->unsignedBigInteger('teknisi_id');
            $table->unsignedBigInteger('sarpras_id');
            $table->date('tanggal_penugasan');
            $table->string('status_penugasan')->default('ditugaskan'); // bisa juga enum
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('teknisi_id')->references('user_id')->on('m_user');
            $table->foreign('sarpras_id')->references('user_id')->on('m_user');
            $table->foreign('laporan_id')->references('laporan_id')->on('t_laporan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_riwayat_penugasan');
    }
};
