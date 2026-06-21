<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Services\SertifikatService;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    protected $sertifikatService;

    public function __construct(SertifikatService $sertifikatService)
    {
        $this->sertifikatService = $sertifikatService;
    }

    public function index()
    {
        $sertifikats = Sertifikat::whereHas('kehadiran.pendaftaran', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->with(['kehadiran.pendaftaran.pelatihan'])
        ->latest()
        ->paginate(10);

        return view('user.sertifikat.index', compact('sertifikats'));
    }

    public function download(Sertifikat $sertifikat)
    {
        // Ensure user owns this certificate
        $kehadiran = $sertifikat->kehadiran->load('pendaftaran');
        if ($kehadiran->pendaftaran->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = $this->sertifikatService->generatePdf($sertifikat);

        return $pdf->download("sertifikat-{$sertifikat->nomor_sertifikat}.pdf");
    }
}

