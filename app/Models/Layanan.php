<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_layanan',
        'harga',
        'estimasi_waktu',
        'deskripsi',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}