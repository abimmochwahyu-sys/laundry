<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_diskon',
        'keterangan',
        'tipe_diskon',
        'nilai',
        'minimum_belanja',
        'berlaku_sampai',
        'is_active'
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'minimum_belanja' => 'decimal:2',
        'berlaku_sampai' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Scope untuk diskon yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('berlaku_sampai', '>=', now());
    }

    /**
     * Cek apakah diskon valid untuk total belanja tertentu
     */
    public function isValidForAmount($total)
    {
        return $this->is_active &&
               $this->berlaku_sampai >= now() &&
               $total >= $this->minimum_belanja;
    }

    /**
     * Hitung nilai diskon
     */
    public function calculateDiscount($total)
    {
        if (!$this->isValidForAmount($total)) {
            return 0;
        }

        if ($this->tipe_diskon === 'persen') {
            return ($total * $this->nilai) / 100;
        } else {
            return min($this->nilai, $total); // Tidak boleh lebih dari total
        }
    }
}