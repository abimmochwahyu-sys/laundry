<?php

namespace Database\Factories;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Layanan>
 */
class LayananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenis_layanan' => fake()->randomElement([
                'Cuci Kering', 'Cuci Basah', 'Setrika', 'Cuci Kering Setrika',
                'Dry Cleaning', 'Cuci Sepatu', 'Cuci Helm'
            ]),
            'deskripsi' => fake()->sentence(),
            'harga' => fake()->numberBetween(5000, 50000),
            'estimasi_waktu' => fake()->numberBetween(1, 7), // dalam hari
        ];
    }
}