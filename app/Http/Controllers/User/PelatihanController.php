<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelatihan::where('status', 'publish')->with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('deskripsi', 'like', "%{$request->search}%");
            });
        }

        $pelatihans = $query->latest('tanggal')->paginate(12);
        $kategoris = KategoriPelatihan::orderBy('nama_kategori')->get();

        return view('user.pelatihan.index', compact('pelatihans', 'kategoris'));
    }

    public function show(Pelatihan $pelatihan)
    {
        $pelatihan->load('kategori');

        $userPendaftaran = auth()->user()->pendaftaran()
            ->where('pelatihan_id', $pelatihan->id)
            ->first();

        return view('user.pelatihan.show', compact('pelatihan', 'userPendaftaran'));
    }
}
