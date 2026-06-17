<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function download(Sertifikat $sertifikat)
    {
        // Ensure user owns this certificate
        $kehadiran = $sertifikat->kehadiran->load('pendaftaran');
        if ($kehadiran->pendaftaran->user_id !== auth()->id()) {
            abort(403);
        }

        // For now, generate a simple text file as placeholder
        $content = "SERTIFIKAT PELATIHAN\n";
        $content .= "====================\n\n";
        $content .= "Nomor: {$sertifikat->nomor_sertifikat}\n";
        $content .= "Tanggal Terbit: {$sertifikat->tanggal_terbit->format('d/m/Y')}\n";
        $content .= "Peserta: {$kehadiran->pendaftaran->user->name}\n";
        $content .= "Pelatihan: {$kehadiran->pendaftaran->pelatihan->judul}\n";

        $filename = "sertifikat-{$sertifikat->nomor_sertifikat}.txt";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
