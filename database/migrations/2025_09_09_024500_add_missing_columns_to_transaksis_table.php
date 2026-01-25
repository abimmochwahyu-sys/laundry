<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Tambahkan kolom-kolom yang mungkin hilang
            if (!Schema::hasColumn('transaksis', 'kode_transaksi')) {
                $table->string('kode_transaksi')->unique()->after('layanan_id');
            }
            
            if (!Schema::hasColumn('transaksis', 'berat')) {
                $table->decimal('berat', 5, 2)->after('kode_transaksi');
            }
            
            if (!Schema::hasColumn('transaksis', 'total_harga')) {
                $table->decimal('total_harga', 10, 2)->after('berat');
            }
            
            if (!Schema::hasColumn('transaksis', 'diskon')) {
                $table->decimal('diskon', 10, 2)->default(0)->after('total_harga');
            }
            
            if (!Schema::hasColumn('transaksis', 'total_akhir')) {
                $table->decimal('total_akhir', 10, 2)->after('diskon');
            }
            
            if (!Schema::hasColumn('transaksis', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->after('total_akhir');
            }
            
            if (!Schema::hasColumn('transaksis', 'status_pembayaran')) {
                $table->string('status_pembayaran')->default('pending')->after('metode_pembayaran');
            }
            
            if (!Schema::hasColumn('transaksis', 'status_transaksi')) {
                $table->string('status_transaksi')->default('pending')->after('status_pembayaran');
            }
            
            if (!Schema::hasColumn('transaksis', 'tanggal_transaksi')) {
                $table->date('tanggal_transaksi')->after('status_transaksi');
            }
            
            if (!Schema::hasColumn('transaksis', 'tanggal_selesai')) {
                $table->date('tanggal_selesai')->nullable()->after('tanggal_transaksi');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus kolom-kolom yang ditambahkan
            $columns = [
                'kode_transaksi',
                'berat',
                'total_harga',
                'diskon',
                'total_akhir',
                'metode_pembayaran',
                'status_pembayaran',
                'status_transaksi',
                'tanggal_transaksi',
                'tanggal_selesai'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('transaksis', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}