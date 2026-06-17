<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';

    protected $fillable = [
        'kategori_id',
        'judul',
        'deskripsi',
        'narasumber',
        'lokasi',
        'tanggal',
        'jam',
        'kuota',
        'persyaratan',
        'status',
        'sertifikat_enabled',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'kuota' => 'integer',
            'sertifikat_enabled' => 'boolean',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPelatihan::class, 'kategori_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class);
    }

    public function isFull(): bool
    {
        if ($this->kuota === null) {
            return false;
        }
        return $this->pendaftaran()->where('status', 'disetujui')->count() >= $this->kuota;
    }

    public function getApprovedCountAttribute(): int
    {
        return $this->pendaftaran()->where('status', 'disetujui')->count();
    }

    public function getPendingCountAttribute(): int
    {
        return $this->pendaftaran()->where('status', 'pending')->count();
    }
}
