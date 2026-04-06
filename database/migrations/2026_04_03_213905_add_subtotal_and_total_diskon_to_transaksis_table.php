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
        if (!Schema::hasColumn('transaksis', 'subtotal')) {
            Schema::table('transaksis', function (Blueprint $table) {
                $table->decimal('subtotal', 15, 2)->default(0); // Akan diletakkan di paling akhir
                $table->decimal('total_diskon', 15, 2)->after('subtotal')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'total_diskon']);
        });
    }
};