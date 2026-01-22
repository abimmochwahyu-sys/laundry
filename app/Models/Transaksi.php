<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
    'user_id', 'layanan_id', 'kode_transaksi', 'berat', 
    'total_harga', 'diskon', 'total_akhir', 'metode_pembayaran',
    'status_pembayaran', 'status_transaksi', 'tanggal_transaksi',
    'tanggal_selesai'
];
    
    protected $casts = ['tanggal_transaksi' => 'datetime'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}