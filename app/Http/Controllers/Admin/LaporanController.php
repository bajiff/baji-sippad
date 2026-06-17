<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelatihan::with('kategori');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $pelatihans = $query->withCount([
            'pendaftaran',
            'pendaftaran as disetujui_count' => fn($q) => $q->where('status', 'disetujui'),
            'pendaftaran as ditolak_count' => fn($q) => $q->where('status', 'ditolak'),
            'pendaftaran as pending_count' => fn($q) => $query->where('status', 'pending'),
        ])->latest('tanggal')->paginate(15);

        return view('admin.laporan.index', compact('pelatihans'));
    }

    public function export(Request $request, string $format)
    {
        $pelatihans = Pelatihan::with(['kategori', 'pendaftaran.user', 'pendaftaran.kehadiran'])
            ->latest('tanggal')
            ->get();

        $data = $pelatihans->map(function ($p) {
            return [
                'Pelatihan' => $p->judul,
                'Kategori' => $p->kategori->nama_kategori,
                'Tanggal' => $p->tanggal->format('d/m/Y'),
                'Total Pendaftar' => $p->pendaftaran->count(),
                'Disetujui' => $p->pendaftaran->where('status', 'disetujui')->count(),
                'Ditolak' => $p->pendaftaran->where('status', 'ditolak')->count(),
                'Hadir' => $p->pendaftaran->filter(fn($p) => $p->kehadiran && $p->kehadiran->status_kehadiran === 'hadir')->count(),
            ];
        });

        if ($format === 'csv') {
            $headers = ['Content-Type' => 'text/csv'];
            $callback = function () use ($data) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, array_keys($data->first()));
                foreach ($data as $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            };
            return Response::stream($callback, 200, $headers, 'laporan-pelatihan.csv');
        }

        return redirect()->route('admin.laporan.index')->with('error', 'Format export belum tersedia.');
    }
}
