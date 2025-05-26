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
    Schema::table('t_perbaikan', function (Blueprint $table) {
        $table->string('foto_perbaikan')->nullable()->after('catatan');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perbaikan', function (Blueprint $table) {
            //
        });
    }
};
