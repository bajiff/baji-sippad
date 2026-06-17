<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_peserta' => User::where('role', 'user')->count(),
            'pelatihan_aktif' => Pelatihan::whereIn('status', ['publish'])->count(),
            'pelatihan_selesai' => Pelatihan::where('status', 'selesai')->count(),
            'total_pendaftaran' => Pendaftaran::count(),
            'menunggu_verifikasi' => Pendaftaran::where('status', 'pending')->count(),
            'total_kehadiran' => Kehadiran::where('status_kehadiran', 'hadir')->count(),
        ];

        $recentPendaftaran = Pendaftaran::with(['user', 'pelatihan'])
            ->latest()
            ->take(10)
            ->get();

        $pelatihanAktif = Pelatihan::where('status', 'publish')
            ->with('kategori')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPendaftaran', 'pelatihanAktif'));
    }
}
