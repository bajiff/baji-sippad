<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
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

        // Check if already registered
        $existing = Pendaftaran::where('user_id', $user->id)
            ->where('pelatihan_id', $pelatihan->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di pelatihan ini.');
        }

        // Check if pelatihan is open
        if ($pelatihan->status !== 'publish') {
            return redirect()->back()->with('error', 'Pelatihan ini belum dibuka atau sudah ditutup.');
        }

        // Check kuota
        if ($pelatihan->isFull()) {
            return redirect()->back()->with('error', 'Kuota pelatihan sudah penuh.');
        }

        Pendaftaran::create([
            'user_id' => $user->id,
            'pelatihan_id' => $pelatihan->id,
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'pending',
        ]);

        return redirect()->route('user.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil! Menunggu verifikasi dari admin.');
    }
}
