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
        Schema::create('t_perbaikan_detail', function (Blueprint $table) {
            $table->id('detail_id');
            $table->unsignedBigInteger('perbaikan_id');
            $table->text('tindakan');
            $table->text('deskripsi')->nullable(); // Opsional
            $table->timestamps();


            $table->foreign(columns: 'perbaikan_id')->references('perbaikan_id')->on('t_perbaikan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_perbaikan_detail');
    }
};
