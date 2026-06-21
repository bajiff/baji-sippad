<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    protected $pendaftaranService;

    public function __construct(PendaftaranService $pendaftaranService)
    {
        $this->pendaftaranService = $pendaftaranService;
    }

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
        $this->pendaftaranService->setujui($pendaftaran);

        return redirect()->back()->with('success', 'Pendaftaran berhasil disetujui.');
    }

    public function tolak(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'alasan_penolakan' => 'nullable|string|max:255'
        ]);

        $this->pendaftaranService->tolak($pendaftaran, $request->input('alasan_penolakan'));

        return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}

