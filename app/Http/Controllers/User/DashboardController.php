<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $pelatihanAktif = Pelatihan::where('status', 'publish')
            ->with('kategori')
            ->latest()
            ->take(5)
            ->get();

        $pendaftaranSaya = Pendaftaran::where('user_id', $user->id)
            ->with('pelatihan')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'terdaftar' => Pendaftaran::where('user_id', $user->id)->count(),
            'disetujui' => Pendaftaran::where('user_id', $user->id)->where('status', 'disetujui')->count(),
            'pending' => Pendaftaran::where('user_id', $user->id)->where('status', 'pending')->count(),
        ];

        return view('user.dashboard', compact('pelatihanAktif', 'pendaftaranSaya', 'stats'));
    }
}
