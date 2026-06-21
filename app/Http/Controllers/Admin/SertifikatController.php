<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Sertifikat;
use App\Services\SertifikatService;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    protected $sertifikatService;

    public function __construct(SertifikatService $sertifikatService)
    {
        $this->sertifikatService = $sertifikatService;
    }

    public function index()
    {
        $pelatihans = Pelatihan::with(['kategori'])
            ->withCount([
                'pendaftaran as total_peserta' => function ($query) {
                    $query->where('status', 'disetujui');
                },
                'pendaftaran as total_hadir' => function ($query) {
                    $query->where('status', 'disetujui')
                          ->whereHas('kehadiran', function ($q) {
                              $q->where('status_kehadiran', 'hadir');
                          });
                },
                'pendaftaran as total_sertifikat' => function ($query) {
                    $query->where('status', 'disetujui')
                          ->whereHas('kehadiran.sertifikat');
                }
            ])
            ->latest()
            ->paginate(10);

        return view('admin.sertifikat.index', compact('pelatihans'));
    }

    public function generate(Pelatihan $pelatihan)
    {
        $count = $this->sertifikatService->generateForPelatihan($pelatihan);

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "{$count} sertifikat berhasil digenerate untuk pelatihan: {$pelatihan->judul}");
    }

    public function showPelatihan(Request $request, Pelatihan $pelatihan)
    {
        $query = $pelatihan->pendaftaran()
            ->where('status', 'disetujui')
            ->with(['user', 'kehadiran.sertifikat']);

        // Filter Kehadiran
        if ($request->filled('kehadiran')) {
            $kehadiran = $request->input('kehadiran');
            if ($kehadiran === 'hadir') {
                $query->whereHas('kehadiran', function ($q) {
                    $q->where('status_kehadiran', 'hadir');
                });
            } elseif ($kehadiran === 'tidak_hadir') {
                $query->whereHas('kehadiran', function ($q) {
                    $q->where('status_kehadiran', 'tidak_hadir');
                });
            } elseif ($kehadiran === 'belum_presensi') {
                $query->whereDoesntHave('kehadiran');
            }
        }

        // Filter Sertifikat
        if ($request->filled('sertifikat')) {
            $sertifikat = $request->input('sertifikat');
            if ($sertifikat === 'terbit') {
                $query->whereHas('kehadiran.sertifikat');
            } elseif ($sertifikat === 'belum_terbit') {
                $query->where(function ($q) {
                    $q->whereDoesntHave('kehadiran')
                      ->orWhereHas('kehadiran', function ($q2) {
                          $q2->whereDoesntHave('sertifikat');
                      });
                });
            }
        }

        $pendaftarans = $query->paginate(20)->withQueryString();

        return view('admin.sertifikat.pelatihan', compact('pelatihan', 'pendaftarans'));
    }

    public function generateBulk(Request $request, Pelatihan $pelatihan)
    {
        $pendaftaranIds = $request->input('pendaftaran_ids', []);
        if (empty($pendaftaranIds)) {
            return redirect()->back()->with('error', 'Tidak ada peserta yang dipilih.');
        }

        // Optimasi: Gunakan Eager Loading untuk meminimalkan N+1 query
        $pendaftarans = \App\Models\Pendaftaran::whereIn('id', $pendaftaranIds)
            ->where('pelatihan_id', $pelatihan->id)
            ->with(['kehadiran.sertifikat'])
            ->get();

        $count = 0;
        foreach ($pendaftarans as $pendaftaran) {
            $kehadiran = $pendaftaran->kehadiran;

            if (!$kehadiran) {
                $kehadiran = \App\Models\Kehadiran::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'status_kehadiran' => 'hadir',
                ]);
            } else if ($kehadiran->status_kehadiran !== 'hadir') {
                $kehadiran->update(['status_kehadiran' => 'hadir']);
            }

            // Memeriksa relasi sertifikat yang telah dieager-load
            if (!$kehadiran->relationLoaded('sertifikat') || !$kehadiran->sertifikat) {
                $nomor = 'SIPPAD-' . $pelatihan->id . '-' . str_pad($kehadiran->id, 4, '0', STR_PAD_LEFT) . '-' . date('Y');
                $kehadiran->sertifikat()->create([
                    'nomor_sertifikat' => $nomor,
                    'tanggal_terbit' => now()->toDateString(),
                ]);
                $count++;
            }
        }

        return redirect()->back()->with('success', "Berhasil menerbitkan {$count} sertifikat baru.");
    }

    public function revokeBulk(Request $request, Pelatihan $pelatihan)
    {
        $pendaftaranIds = $request->input('pendaftaran_ids', []);
        if (empty($pendaftaranIds)) {
            return redirect()->back()->with('error', 'Tidak ada peserta yang dipilih.');
        }

        // Optimasi: Membaca seluruh data sekaligus dan melalukan bulk delete
        $pendaftarans = \App\Models\Pendaftaran::whereIn('id', $pendaftaranIds)
            ->where('pelatihan_id', $pelatihan->id)
            ->with(['kehadiran.sertifikat'])
            ->get();

        $kehadiranIdsWithSertifikat = [];
        foreach ($pendaftarans as $pendaftaran) {
            if ($pendaftaran->kehadiran && $pendaftaran->kehadiran->sertifikat) {
                $kehadiranIdsWithSertifikat[] = $pendaftaran->kehadiran->id;
            }
        }

        $count = 0;
        if (!empty($kehadiranIdsWithSertifikat)) {
            $count = \App\Models\Sertifikat::whereIn('kehadiran_id', $kehadiranIdsWithSertifikat)->delete();
        }

        return redirect()->back()->with('success', "Berhasil membatalkan {$count} sertifikat.");
    }

    public function download(Sertifikat $sertifikat)
    {
        return $this->sertifikatService->generatePdf($sertifikat)
            ->download("Sertifikat-{$sertifikat->nomor_sertifikat}.pdf");
    }
}

