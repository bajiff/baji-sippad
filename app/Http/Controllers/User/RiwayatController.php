<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = Pendaftaran::where('user_id', auth()->id())
            ->where('status', 'disetujui')
            ->with(['pelatihan.kategori', 'pelatihan.dokumentasi', 'kehadiran.sertifikat'])
            ->latest()
            ->paginate(10);

        return view('user.riwayat.index', compact('riwayat'));
    }
}
