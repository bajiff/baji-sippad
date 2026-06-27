<?php

namespace App\Services;

use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Notifications\PendaftaranStatusNotification;
use Exception;

class PendaftaranService
{
    /**
     * Mendaftar pelatihan untuk user.
     *
     * @param User $user
     * @param Pelatihan $pelatihan
     * @return Pendaftaran
     * @throws Exception
     */
    public function daftar(User $user, Pelatihan $pelatihan): Pendaftaran
    {
        // Check if already registered
        $existing = Pendaftaran::where('user_id', $user->id)
            ->where('pelatihan_id', $pelatihan->id)
            ->first();

        if ($existing) {
            throw new Exception('Anda sudah terdaftar di pelatihan ini.');
        }

        // Check if pelatihan is open
        if ($pelatihan->status !== 'publish') {
            throw new Exception('Pelatihan ini belum dibuka atau sudah ditutup.');
        }

        // Check kuota
        if ($pelatihan->isFull()) {
            throw new Exception('Kuota pelatihan sudah penuh.');
        }

        return Pendaftaran::create([
            'user_id' => $user->id,
            'pelatihan_id' => $pelatihan->id,
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'pending',
        ]);
    }

    /**
     * Menyetujui pendaftaran pelatihan.
     *
     * @param Pendaftaran $pendaftaran
     * @return void
     */
    public function setujui(Pendaftaran $pendaftaran): void
    {
        $pelatihan = $pendaftaran->pelatihan;
        if ($pelatihan->isFull()) {
            throw new Exception('Gagal menyetujui: Kuota pelatihan sudah penuh (' . $pelatihan->approved_count . '/' . $pelatihan->kuota . '). Silakan perbarui kuota pelatihan terlebih dahulu.');
        }

        $pendaftaran->update(['status' => 'disetujui']);

        // Auto-close pelatihan if kuota is full
        if ($pelatihan->isFull()) {
            $pelatihan->update(['status' => 'closed']);
        }

        // Kirim notifikasi ke user
        $pendaftaran->user->notify(new PendaftaranStatusNotification($pendaftaran));
    }

    /**
     * Menolak pendaftaran pelatihan.
     *
     * @param Pendaftaran $pendaftaran
     * @param string|null $alasan
     * @return void
     */
    public function tolak(Pendaftaran $pendaftaran, ?string $alasan = null): void
    {
        $pendaftaran->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $alasan
        ]);

        // Kirim notifikasi ke user
        $pendaftaran->user->notify(new PendaftaranStatusNotification($pendaftaran));
    }
}
