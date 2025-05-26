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
        Schema::create('t_feedback', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->unsignedBigInteger(column: 'laporan_id');
            $table->integer('rating')->comment('1-5');
            $table->text('komentar')->nullable();
            $table->timestamps();


            $table->foreign(columns: 'laporan_id')->references('laporan_id')->on('t_laporan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_feedback');
    }
};
