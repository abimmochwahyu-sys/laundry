<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    /**
     * Field yang boleh diisi mass assignment
     */
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
        // optional untuk Midtrans
        'snap_token',
        'payment_type',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total_harga'       => 'integer',
        'diskon'            => 'integer',
        'total_akhir'       => 'integer',
    ];

    /**
     * =====================
     * RELATIONS
     * =====================
     */

    // Transaksi milik user (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Transaksi punya satu layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * =====================
     * MUTATORS / ACCESSORS (opsional)
     * =====================
     */

    // total_akhir dengan format rupiah
    public function getTotalAkhirFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_akhir, 0, ',', '.');
    }

    // diskon dengan format rupiah
    public function getDiskonFormattedAttribute()
    {
        return 'Rp ' . number_format($this->diskon, 0, ',', '.');
    }

    // total_harga dengan format rupiah
    public function getTotalHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }
}
