<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeTransaksiToTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('transaksis', 'kode_transaksi')) {
            Schema::table('transaksis', function (Blueprint $table) {
                $table->string('kode_transaksi')->unique()->after('layanan_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('transaksis', 'kode_transaksi')) {
            Schema::table('transaksis', function (Blueprint $table) {
                $table->dropColumn('kode_transaksi');
            });
        }
    }
}