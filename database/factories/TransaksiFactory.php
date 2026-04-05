<?php

namespace Database\Factories;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $layanan = Layanan::factory()->create();
        $berat = fake()->randomFloat(1, 0.5, 10);
        $totalHarga = $layanan->harga * $berat;

        return [
            'user_id' => User::factory(),
            'layanan_id' => $layanan->id,
            'kode_transaksi' => 'TRX-' . fake()->unique()->numberBetween(100000, 999999),
            'berat' => $berat,
            'total_harga' => $totalHarga,
            'diskon' => fake()->numberBetween(0, 5000),
            'total_akhir' => $totalHarga - fake()->numberBetween(0, 5000),
            'metode_pembayaran' => fake()->randomElement(['cash', 'transfer', 'midtrans']),
            'status_pembayaran' => fake()->randomElement(['pending', 'paid', 'failed']),
            'status_transaksi' => fake()->randomElement(['pending', 'proses', 'selesai', 'diambil']),
            'tanggal_transaksi' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}