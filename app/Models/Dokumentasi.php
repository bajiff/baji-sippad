<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi';

    protected $fillable = [
        'pelatihan_id',
        'foto_kegiatan',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
