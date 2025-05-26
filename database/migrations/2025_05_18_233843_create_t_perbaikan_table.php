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
        Schema::create('t_perbaikan', function (Blueprint $table) {
            $table->id('perbaikan_id');
            $table->unsignedBigInteger('laporan_id');
            $table->unsignedBigInteger('teknisi_id');
            $table->timestamp('tanggal_mulai');
            $table->timestamp('tanggal_selesai')->nullable();
            $table->string('status', 20)->default('dalam_antrian')->comment('dalam_antrian, diproses, selesai');
            $table->text('catatan')->nullable();
            $table->timestamps();


            $table->foreign(columns: 'laporan_id')->references('laporan_id')->on('t_laporan')->onDelete('cascade');
            $table->foreign(columns: 'teknisi_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_perbaikan');
    }
};
