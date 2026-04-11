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
        'diskon_id',
        'kode_transaksi',
        'berat',
        'subtotal',
        'total_diskon',
        'diskon',
        'total_harga',
        'total_akhir',
        'metode_pembayaran',
        'status_pembayaran',
        'status_transaksi',
        'tanggal_transaksi',
        'tanggal_selesai',
        // optional untuk Midtrans
        'snap_token',
        'payment_type',
        'nama_guest',
        'no_hp_guest',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'berat' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total_diskon' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'total_akhir' => 'decimal:2',
        'tanggal_transaksi' => 'date',
        'tanggal_selesai' => 'date',
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

    /**
     * Accessor untuk nama pelanggan (User atau Guest)
     */
    public function getCustomerNameAttribute()
    {
        return $this->user ? $this->user->name : ($this->nama_guest ?? 'Guest');
    }

    /**
     * Accessor untuk nomor telepon (User->Pelanggan atau Guest)
     */
    public function getCustomerPhoneAttribute()
    {
        if ($this->user && $this->user->pelanggan) {
            return $this->user->pelanggan->telepon;
        }
        return $this->no_hp_guest;
    }

    // Transaksi punya satu layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    // Transaksi bisa punya diskon (nullable)
    public function promo()
    {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }

    /**
     * =====================
     * MUTATORS / ACCESSORS (opsional)
     * =====================
     */

    // total_harga dengan format rupiah
    public function getTotalHargaFormattedAttribute()
    {
        return 'Rp ' . number_format((float) $this->total_harga, 0, ',', '.');
    }

    // subtotal dengan format rupiah
    public function getSubtotalFormattedAttribute()
    {
        return 'Rp ' . number_format((float) $this->subtotal, 0, ',', '.');
    }

    // total_diskon dengan format rupiah
    public function getTotalDiskonFormattedAttribute()
    {
        return 'Rp ' . number_format((float) $this->total_diskon, 0, ',', '.');
    }
}
