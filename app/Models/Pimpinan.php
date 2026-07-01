<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pimpinan extends Model
{
    protected $table = 'pimpinans';

    protected $fillable = [
        'nama_desa',
        'nama_kepala_desa',
    ];
}
