<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'photo', 
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke Transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }

   public function pelanggan()
{
    return $this->hasOne(Pelanggan::class);
}

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    /**
     * Get user initials (e.g. John Doe -> JD)
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }
}
