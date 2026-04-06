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
        if (!Schema::hasColumn('transaksis', 'diskon_id')) {
            Schema::table('transaksis', function (Blueprint $table) {
                $table->foreignId('diskon_id')->nullable()->after('layanan_id')
                      ->constrained('diskons')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['diskon_id']);
            $table->dropColumn('diskon_id');
        });
    }
};