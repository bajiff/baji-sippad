<?php

namespace App\Services;

use App\Models\Kehadiran;
use App\Models\Pelatihan;
use App\Models\Sertifikat;
use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatService
{
    /**
     * Generate sertifikat untuk semua peserta yang hadir pada pelatihan tertentu dan belum memiliki sertifikat.
     *
     * @param Pelatihan $pelatihan
     * @return int Jumlah sertifikat yang berhasil digenerate
     */
    public function generateForPelatihan(Pelatihan $pelatihan): int
    {
        $kehadirans = Kehadiran::where('status_kehadiran', 'hadir')
            ->whereHas('pendaftaran', function ($query) use ($pelatihan) {
                $query->where('pelatihan_id', $pelatihan->id);
            })
            ->whereDoesntHave('sertifikat')
            ->get();

        $count = 0;
        foreach ($kehadirans as $kehadiran) {
            $nomor = 'SIPPAD-' . $pelatihan->id . '-' . str_pad($kehadiran->id, 4, '0', STR_PAD_LEFT) . '-' . date('Y');

            Sertifikat::create([
                'kehadiran_id' => $kehadiran->id,
                'nomor_sertifikat' => $nomor,
                'tanggal_terbit' => now()->toDateString(),
            ]);
            $count++;
        }

        return $count;
    }

    /**
     * Membuat file PDF sertifikat resmi.
     *
     * @param Sertifikat $sertifikat
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generatePdf(Sertifikat $sertifikat)
    {
        $kehadiran = $sertifikat->kehadiran->load(['pendaftaran.user', 'pendaftaran.pelatihan']);

        return Pdf::loadView('pdf.sertifikat', compact('sertifikat', 'kehadiran'));
    }
}
