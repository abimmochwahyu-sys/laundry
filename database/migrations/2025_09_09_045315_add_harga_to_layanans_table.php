<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaToLayanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layanans', function (Blueprint $table) {
            if (!Schema::hasColumn('layanans', 'harga')) {
                $table->integer('harga')->after('jenis_layanan');
            }
            
            if (!Schema::hasColumn('layanans', 'estimasi_waktu')) {
                $table->integer('estimasi_waktu')->after('harga');
            }
            
            if (!Schema::hasColumn('layanans', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('estimasi_waktu');
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
        Schema::table('layanans', function (Blueprint $table) {
            if (Schema::hasColumn('layanans', 'harga')) {
                $table->dropColumn('harga');
            }
            
            if (Schema::hasColumn('layanans', 'estimasi_waktu')) {
                $table->dropColumn('estimasi_waktu');
            }
            
            if (Schema::hasColumn('layanans', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }
}