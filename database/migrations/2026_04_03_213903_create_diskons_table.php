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
        if (!Schema::hasTable('diskons')) {
            Schema::create('diskons', function (Blueprint $table) {
                $table->id();
                $table->string('kode_diskon')->unique();
                $table->string('keterangan');
                $table->enum('tipe_diskon', ['persen', 'nominal']);
                $table->decimal('nilai', 10, 2);
                $table->decimal('minimum_belanja', 15, 2)->default(0);
                $table->date('berlaku_sampai');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};