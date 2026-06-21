<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Services\LaporanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index(Request $request)
    {
        $pelatihans = $this->laporanService->getLaporanPaginated($request->only(['tahun', 'bulan', 'kategori_id']));

        return view('admin.laporan.index', compact('pelatihans'));
    }

    public function export(Request $request, string $format)
    {
        $filters = $request->only(['tahun', 'bulan', 'kategori_id']);

        if ($format === 'csv') {
            $data = $this->laporanService->getExportData($filters);
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="laporan-pelatihan.csv"',
            ];
            $callback = function () use ($data) {
                $handle = fopen('php://output', 'w');
                if ($data->isNotEmpty()) {
                    fputcsv($handle, array_keys($data->first()));
                    foreach ($data as $row) {
                        fputcsv($handle, $row);
                    }
                }
                fclose($handle);
            };
            return Response::stream($callback, 200, $headers);
        }

        if ($format === 'xlsx') {
            $pelatihans = $this->laporanService->getLaporanData($filters);

            $totalPelatihan = $pelatihans->count();
            $totalPendaftar = 0;
            $totalDisetujui = 0;
            $totalHadir = 0;

            foreach ($pelatihans as $p) {
                $totalPendaftar += $p->pendaftaran->count();
                $totalDisetujui += $p->pendaftaran->where('status', 'disetujui')->count();
                $totalHadir += $p->pendaftaran->filter(fn($pendaftar) => $pendaftar->kehadiran && $pendaftar->kehadiran->status_kehadiran === 'hadir')->count();
            }

            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\LaporanExport(
                    $pelatihans,
                    $filters,
                    $totalPelatihan,
                    $totalPendaftar,
                    $totalDisetujui,
                    $totalHadir
                ),
                'laporan-pelatihan.xlsx'
            );
        }

        if ($format === 'pdf') {
            $pdf = $this->laporanService->generatePdf($filters);
            return $pdf->download('laporan-pelatihan.pdf');
        }

        return redirect()->route('admin.laporan.index')->with('error', 'Format export belum tersedia.');
    }
}

