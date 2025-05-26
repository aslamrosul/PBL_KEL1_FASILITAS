<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('m_gedung', function (Blueprint $table) {
            $table->id('gedung_id');
            $table->string('gedung_kode', 10);
            $table->string('gedung_nama', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_gedung');
    }
};
