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
        Schema::table('transaksis', function (Blueprint $table) {
            // Ubah user_id menjadi nullable
            $table->foreignId('user_id')->nullable()->change();

            // Tambah kolom guest
            $table->string('nama_guest')->nullable()->after('user_id');
            $table->string('no_hp_guest')->nullable()->after('nama_guest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Kembalikan user_id menjadi tidak nullable
            // Catatan: Ini mungkin gagal jika ada data null
            $table->foreignId('user_id')->nullable(false)->change();

            $table->dropColumn(['nama_guest', 'no_hp_guest']);
        });
    }
};
