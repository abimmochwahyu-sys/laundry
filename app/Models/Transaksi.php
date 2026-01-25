<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis'; // pastikan sesuai nama tabel

    protected $fillable = [
        'user_id',
        'layanan_id',
        'kode_transaksi',
        'berat',
        'total_harga',
        'diskon',
        'total_akhir',
        'metode_pembayaran',
        'status_pembayaran',
        'status_transaksi',
        'tanggal_transaksi',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // Relasi ke layanan
    public function layanan()
    {
        return $this->belongsTo(\App\Models\Layanan::class, 'layanan_id');
    }
}
