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
        Schema::create('t_laporan_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->unsignedBigInteger('laporan_id');
            $table->unsignedBigInteger('user_id');
            $table->string('aksi', 50)->comment('buat laporan, update status, dll');
            $table->text('keterangan')->nullable();
            $table->timestamps();


            $table->foreign(columns: 'user_id')->references('user_id')->on('m_user')->onDelete('cascade');
            $table->foreign(columns: 'laporan_id')->references('laporan_id')->on('t_laporan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_laporan_history');
    }
};
