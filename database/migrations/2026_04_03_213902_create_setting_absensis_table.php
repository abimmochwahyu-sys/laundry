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
    Schema::create('setting_absensis', function (Blueprint $table) {
        $table->id();
        $table->time('jam_masuk');
        $table->time('batas_telat');
        $table->time('jam_keluar');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_absensis');
    }
};
