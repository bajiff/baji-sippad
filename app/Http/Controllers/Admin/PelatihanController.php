<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['sertifikat_enabled'] = $request->boolean('sertifikat_enabled');

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['sertifikat_enabled'] = $request->boolean('sertifikat_enabled');

        if ($request->hasFile('thumbnail')) {
            if ($pelatihan->thumbnail) {
                Storage::disk('public')->delete($pelatihan->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $pelatihan->update($validated);

        if ($pelatihan->isFull() && $pelatihan->status === 'publish') {
            $pelatihan->update(['status' => 'closed']);
        }

        return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy(Pelatihan $pelatihan)
    {
        if ($pelatihan->thumbnail) {
            Storage::disk('public')->delete($pelatihan->thumbnail);
        }
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
