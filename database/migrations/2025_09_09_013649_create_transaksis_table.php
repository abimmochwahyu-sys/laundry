<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Cek apakah tabel sudah ada
        if (!Schema::hasTable('transaksis')) {
            Schema::create('transaksis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('layanan_id')->constrained()->onDelete('cascade');
                $table->string('kode_transaksi')->unique();
                $table->decimal('berat', 5, 2);
                $table->decimal('total_harga', 10, 2);
                $table->decimal('diskon', 10, 2)->default(0);
                $table->decimal('total_akhir', 10, 2);
                $table->string('metode_pembayaran');
                $table->string('status_pembayaran')->default('pending');
                $table->string('status_transaksi')->default('pending');
                $table->date('tanggal_transaksi');
                $table->date('tanggal_selesai')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('transaksis');
    }
}