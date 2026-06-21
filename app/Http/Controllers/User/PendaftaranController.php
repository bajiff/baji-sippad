<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Exception;

class PendaftaranController extends Controller
{
    protected $pendaftaranService;

    public function __construct(PendaftaranService $pendaftaranService)
    {
        $this->pendaftaranService = $pendaftaranService;
    }

    public function index()
    {
        $pendaftarans = Pendaftaran::where('user_id', auth()->id())
             ->with('pelatihan.kategori')
             ->latest()
             ->paginate(10);

        return view('user.pendaftaran.index', compact('pendaftarans'));
    }

    public function store(Pelatihan $pelatihan)
    {
        $user = auth()->user();

        try {
            $this->pendaftaranService->daftar($user, $pelatihan);

            return redirect()->route('user.pendaftaran.index')
                ->with('success', 'Pendaftaran berhasil! Menunggu verifikasi dari admin.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function presensiMandiri(Pendaftaran $pendaftaran)
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

        \App\Models\Kehadiran::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            ['status_kehadiran' => 'hadir']
        );

        return redirect()->back()->with('success', 'Presensi kehadiran Anda berhasil dicatat.');
    }
}

