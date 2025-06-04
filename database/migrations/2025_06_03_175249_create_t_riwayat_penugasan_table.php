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
        $table->id();
        $table->foreignId('laporan_id')->constrained('laporan'); // ganti jika nama tabel berbeda
        $table->foreignId('teknisi_id')->constrained('users');
        $table->foreignId('sarpras_id')->constrained('users');
        $table->date('tanggal_penugasan');
        $table->string('status_penugasan')->default('ditugaskan'); // bisa juga enum
        $table->text('catatan')->nullable();
        $table->timestamps();
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
