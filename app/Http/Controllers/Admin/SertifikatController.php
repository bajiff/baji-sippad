<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Pelatihan;
use App\Models\Sertifikat;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function index()
    {
        $sertifikats = Sertifikat::with(['kehadiran.pendaftaran.user', 'kehadiran.pendaftaran.pelatihan'])
            ->latest()
            ->paginate(15);

        return view('admin.sertifikat.index', compact('sertifikats'));
    }

    public function generate(Pelatihan $pelatihan)
    {
        $kehadirans = Kehadiran::where('status_kehadiran', 'hadir')
            ->whereDoesntHave('sertifikat')
            ->with('pendaftaran')
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

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "{$count} sertifikat berhasil digenerate untuk pelatihan: {$pelatihan->judul}");
    }
}
