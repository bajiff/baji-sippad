<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index()
    {
        $pelatihans = Pelatihan::with('kategori')
            ->latest()
            ->paginate(10);

        return view('admin.pelatihan.index', compact('pelatihans'));
    }

    public function create()
    {
        $kategoris = KategoriPelatihan::orderBy('nama_kategori')->get();
        return view('admin.pelatihan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_pelatihan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'narasumber' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date|after:today',
            'jam' => 'required',
            'kuota' => 'nullable|integer|min:1',
            'persyaratan' => 'nullable|string',
            'sertifikat_enabled' => 'boolean',
        ]);

        $validated['sertifikat_enabled'] = $request->boolean('sertifikat_enabled');

        Pelatihan::create($validated);

        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function edit(Pelatihan $pelatihan)
    {
        $kategoris = KategoriPelatihan::orderBy('nama_kategori')->get();
        return view('admin.pelatihan.edit', compact('pelatihan', 'kategoris'));
    }

    public function update(Request $request, Pelatihan $pelatihan)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_pelatihan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'narasumber' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kuota' => 'nullable|integer|min:1',
            'persyaratan' => 'nullable|string',
            'sertifikat_enabled' => 'boolean',
        ]);

        $validated['sertifikat_enabled'] = $request->boolean('sertifikat_enabled');

        $pelatihan->update($validated);

        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy(Pelatihan $pelatihan)
    {
        $pelatihan->delete();
        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Pelatihan $pelatihan)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,publish,closed,selesai',
        ]);

        $pelatihan->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status pelatihan berhasil diperbarui.');
    }
}
