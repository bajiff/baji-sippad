<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\Pelatihan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::whereIn('status', ['publish', 'selesai', 'closed'])
            ->withCount(['pendaftaran' => fn($q) => $q->where('status', 'disetujui')])
            ->with('kategori')
            ->latest()
            ->paginate(10);

        return view('admin.kehadiran.index', compact('pelatihans'));
    }

    public function show(Pelatihan $pelatihan)
    {
        $pendaftarans = Pendaftaran::where('pelatihan_id', $pelatihan->id)
            ->where('status', 'disetujui')
            ->with(['user', 'kehadiran'])
            ->get();

        return view('admin.kehadiran.show', compact('pelatihan', 'pendaftarans'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'status_kehadiran' => 'required|in:hadir,tidak_hadir',
        ]);

        Kehadiran::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id],
            ['status_kehadiran' => $validated['status_kehadiran']]
        );

        return redirect()->back()->with('success', 'Kehadiran berhasil diperbarui.');
    }

    public function toggleMode(Request $request, Pelatihan $pelatihan)
    {
        $validated = $request->validate([
            'presensi_by' => 'required|in:admin,peserta',
        ]);

        $pelatihan->update([
            'presensi_by' => $validated['presensi_by']
        ]);

        return redirect()->back()->with('success', 'Metode presensi berhasil diperbarui.');
    }
}
