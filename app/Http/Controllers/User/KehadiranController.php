<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index()
    {
        $pendaftarans = Pendaftaran::where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->with(['pelatihan.kategori', 'kehadiran'])
            ->latest()
            ->paginate(10);

        return view('user.kehadiran.index', compact('pendaftarans'));
    }

    public function store(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== auth()->id()) {
            abort(403);
        }

        if ($pendaftaran->status !== 'disetujui') {
            return redirect()->back()->with('error', 'Pendaftaran Anda belum disetujui.');
        }

        $pelatihan = $pendaftaran->pelatihan;
        if (!in_array($pelatihan->status, ['publish', 'selesai'])) {
            return redirect()->back()->with('error', 'Pelatihan belum aktif atau sudah ditutup.');
        }

        if ($pelatihan->presensi_by !== 'peserta') {
            return redirect()->back()->with('error', 'Presensi mandiri dinonaktifkan oleh admin.');
        }

        Kehadiran::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            ['status_kehadiran' => 'hadir']
        );

        return redirect()->back()->with('success', 'Presensi kehadiran Anda berhasil dicatat.');
    }
}
