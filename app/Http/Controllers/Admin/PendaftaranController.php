<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'pelatihan.kategori']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('pelatihan_id')) {
            $query->where('pelatihan_id', $request->pelatihan_id);
        }

        $pendaftarans = $query->latest()->paginate(15);

        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function setujui(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update(['status' => 'disetujui']);

        // Auto-close pelatihan if kuota is full
        $pelatihan = $pendaftaran->pelatihan;
        if ($pelatihan->isFull()) {
            $pelatihan->update(['status' => 'closed']);
        }

        return redirect()->back()->with('success', 'Pendaftaran berhasil disetujui.');
    }

    public function tolak(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update(['status' => 'ditolak']);

        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}
