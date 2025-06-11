<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('m_pairwise_kriteria', function (Blueprint $table) {
            $table->id('pairwise_id');
            $table->foreignId('kriteria_id_1')->constrained('m_kriteria', 'kriteria_id')->onDelete('cascade');
            $table->foreignId('kriteria_id_2')->constrained('m_kriteria', 'kriteria_id')->onDelete('cascade');
            $table->float('nilai')->default(1.0); // Nilai perbandingan (1-9 atau 1/9-1)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_pairwise_kriteria');
    }
};