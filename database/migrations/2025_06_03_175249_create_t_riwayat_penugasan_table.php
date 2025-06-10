<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRiwayatPenugasanTable extends Migration
{
    public function up()
    {
        Schema::create('t_riwayat_penugasan', function (Blueprint $table) {
            $table->id('riwayat_penugasan_id');
            $table->unsignedBigInteger('laporan_id');
            $table->unsignedBigInteger('teknisi_id');
            $table->unsignedBigInteger('sarpras_id');
            $table->date('tanggal_penugasan');
            $table->enum('status_penugasan', ['ditugaskan', 'dikerjakan', 'selesai'])->default('ditugaskan');
            $table->text('catatan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('laporan_id')->references('laporan_id')->on('t_laporan')->onDelete('cascade');
            $table->foreign('teknisi_id')->references('user_id')->on('m_user');
            $table->foreign('sarpras_id')->references('user_id')->on('m_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_riwayat_penugasan');
    }
}