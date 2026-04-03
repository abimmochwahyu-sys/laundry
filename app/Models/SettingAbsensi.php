<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SettingAbsensi extends Model
{
    protected $fillable = [
        'jam_masuk',
        'batas_telat',
        'jam_keluar'
    ];
}
