<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';

    protected $fillable = [
        'id',
        'user_id',
        'alamat',
        'telepon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

