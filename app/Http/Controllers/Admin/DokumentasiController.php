<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::with('dokumentasi')->latest()->paginate(10);

        return view('admin.dokumentasi.index', compact('pelatihans'));
    }

    public function create()
    {
        $pelatihans = Pelatihan::orderBy('judul')->get();
        return view('admin.dokumentasi.create', compact('pelatihans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelatihan_id' => 'required|exists:pelatihan,id',
            'foto' => 'required|image|max:5120',
        ]);

        $path = $request->file('foto')->store('dokumentasi', 'public');

        Dokumentasi::create([
            'pelatihan_id' => $validated['pelatihan_id'],
            'foto_kegiatan' => $path,
        ]);

        return redirect()->route('admin.dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function edit(Dokumentasi $dokumentasi)
    {
        $pelatihans = Pelatihan::orderBy('judul')->get();
        return view('admin.dokumentasi.edit', compact('dokumentasi', 'pelatihans'));
    }

    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        $validated = $request->validate([
            'pelatihan_id' => 'required|exists:pelatihan,id',
            'foto' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($dokumentasi->foto_kegiatan) {
                Storage::disk('public')->delete($dokumentasi->foto_kegiatan);
            }
            $validated['foto_kegiatan'] = $request->file('foto')->store('dokumentasi', 'public');
        }

        $dokumentasi->update([
            'pelatihan_id' => $validated['pelatihan_id'],
            'foto_kegiatan' => $validated['foto_kegiatan'] ?? $dokumentasi->foto_kegiatan,
        ]);

        return redirect()->route('admin.dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy(Dokumentasi $dokumentasi)
    {
        Storage::disk('public')->delete($dokumentasi->foto_kegiatan);
        $dokumentasi->delete();

        return redirect()->route('admin.dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus.');
    }
}
