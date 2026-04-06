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
            $table->decimal('berat', 15, 2)->change();
            $table->decimal('subtotal', 15, 2)->change();
            $table->decimal('total_diskon', 15, 2)->change();
            $table->decimal('diskon', 15, 2)->change();
            $table->decimal('total_harga', 15, 2)->change();
            $table->decimal('total_akhir', 15, 2)->change();
        });

        Schema::table('diskons', function (Blueprint $table) {
            $table->decimal('nilai', 15, 2)->change();
            $table->decimal('minimum_belanja', 15, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->decimal('berat', 5, 2)->change();
            $table->decimal('subtotal', 10, 2)->change();
            $table->decimal('total_diskon', 10, 2)->change();
            $table->decimal('diskon', 10, 2)->change();
            $table->decimal('total_harga', 10, 2)->change();
            $table->decimal('total_akhir', 10, 2)->change();
        });

        Schema::table('diskons', function (Blueprint $table) {
            $table->decimal('nilai', 10, 2)->change();
            $table->decimal('minimum_belanja', 10, 2)->change();
        });
    }
};
