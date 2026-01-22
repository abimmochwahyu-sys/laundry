<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeskripsiToLayanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Cek apakah kolom sudah ada
        if (!Schema::hasColumn('layanans', 'deskripsi')) {
            Schema::table('layanans', function (Blueprint $table) {
                $table->text('deskripsi')->nullable()->after('estimasi_waktu');
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
        // Hanya hapus kolom jika ada
        if (Schema::hasColumn('layanans', 'deskripsi')) {
            Schema::table('layanans', function (Blueprint $table) {
                $table->dropColumn('deskripsi');
            });
        }
    }
}