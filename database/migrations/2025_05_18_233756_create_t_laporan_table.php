<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_laporan', function (Blueprint $table) {
            $table->bigIncrements('laporan_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('fasilitas_id');
            
             // Data laporan
            $table->string('judul', 100);
            $table->text('deskripsi');
            $table->string('foto_path')->nullable();
            
            $table->timestamp('tanggal_lapor')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('bobot_id')->nullable();
            
            $table->string('status', 20)->default('menunggu')->comment('menunggu,diterima, diproses, selesai, ditolak');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign(columns: 'user_id')->references('user_id')->on('m_user')->onDelete('cascade');
            $table->foreign('periode_id')->references('periode_id')->on('m_periode')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('m_fasilitas')->onDelete('cascade');
            $table->foreign('bobot_id')->references('bobot_id')->on('m_bobot_prioritas')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_laporan');
    }
};
