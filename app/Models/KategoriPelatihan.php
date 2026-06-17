<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPelatihan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pelatihan';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class, 'kategori_id');
    }
}
