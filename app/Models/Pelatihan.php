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
        'ketua_pelaksana',
        'lokasi',
        'tanggal',
        'jam',
        'kuota',
        'persyaratan',
        'thumbnail',
        'status',
        'sertifikat_enabled',
        'presensi_by',
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
        return $this->approved_count >= $this->kuota;
    }

    public function getApprovedCountAttribute(): int
    {
        if (array_key_exists('approved_pendaftaran_count', $this->attributes)) {
            return (int) $this->attributes['approved_pendaftaran_count'];
        }

        if ($this->relationLoaded('pendaftaran')) {
            return $this->pendaftaran->where('status', 'disetujui')->count();
        }

        return $this->pendaftaran()->where('status', 'disetujui')->count();
    }

    public function getPendingCountAttribute(): int
    {
        if (array_key_exists('pending_pendaftaran_count', $this->attributes)) {
            return (int) $this->attributes['pending_pendaftaran_count'];
        }

        if ($this->relationLoaded('pendaftaran')) {
            return $this->pendaftaran->where('status', 'pending')->count();
        }

        return $this->pendaftaran()->where('status', 'pending')->count();
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('landing_categories');
            \Illuminate\Support\Facades\Cache::forget('landing_latest_trainings');
            \Illuminate\Support\Facades\Cache::forget('landing_stats');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('landing_categories');
            \Illuminate\Support\Facades\Cache::forget('landing_latest_trainings');
            \Illuminate\Support\Facades\Cache::forget('landing_stats');
        });
    }
}
