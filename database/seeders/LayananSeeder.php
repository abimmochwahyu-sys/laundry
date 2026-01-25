<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layanans = [
            [
                'jenis_layanan' => 'Cuci Kering',
                'harga' => 10000,
                'estimasi_waktu' => 2,
                'deskripsi' => 'Cuci bersih dengan deterjen berkualitas dan pengeringan dengan mesin dryer'
            ],
            [
                'jenis_layanan' => 'Cuci Setrika',
                'harga' => 15000,
                'estimasi_waktu' => 3,
                'deskripsi' => 'Cuci bersih, pengeringan, dan setrika rapi dengan hasil wangi'
            ],
            [
                'jenis_layanan' => 'Setrika Saja',
                'harga' => 8000,
                'estimasi_waktu' => 1,
                'deskripsi' => 'Setrika rapi untuk pakaian yang sudah bersih'
            ]
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}