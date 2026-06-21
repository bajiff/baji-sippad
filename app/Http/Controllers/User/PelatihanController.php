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
        $query = Pelatihan::whereIn('status', ['publish', 'closed'])->with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(judul) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(deskripsi) LIKE ?', ["%{$search}%"]);
            });
        }

        $pelatihans = $query->latest('tanggal')->paginate(12);
        $kategoris = KategoriPelatihan::orderBy('nama_kategori')->get();

        return view('user.pelatihan.index', compact('pelatihans', 'kategoris'));
    }

    public function show(Pelatihan $pelatihan)
    {
        $pelatihan->load('kategori')->loadCount(['pendaftaran as approved_pendaftaran_count' => function ($query) {
            $query->where('status', 'disetujui');
        }]);

        $userPendaftaran = auth()->user()->pendaftaran()
            ->where('pelatihan_id', $pelatihan->id)
            ->with('kehadiran')
            ->first();

        return view('user.pelatihan.show', compact('pelatihan', 'userPendaftaran'));
    }
}
