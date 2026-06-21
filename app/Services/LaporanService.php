<?php

namespace App\Services;

use App\Models\Pelatihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class LaporanService
{
    /**
     * Mendapatkan data laporan pelatihan terpaginasi dengan filter.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getLaporanPaginated(array $filters = [], int $perPage = 15)
    {
        $query = Pelatihan::with('kategori');

        if (!empty($filters['tahun'])) {
            $query->whereYear('tanggal', $filters['tahun']);
        }
        if (!empty($filters['bulan'])) {
            $query->whereMonth('tanggal', $filters['bulan']);
        }
        if (!empty($filters['kategori_id'])) {
            $query->where('kategori_id', $filters['kategori_id']);
        }

        return $query->withCount([
            'pendaftaran',
            'pendaftaran as disetujui_count' => fn($q) => $q->where('status', 'disetujui'),
            'pendaftaran as ditolak_count' => fn($q) => $q->where('status', 'ditolak'),
            'pendaftaran as pending_count' => fn($q) => $q->where('status', 'pending'),
        ])->latest('tanggal')->paginate($perPage);
    }

    /**
     * Mendapatkan data laporan terformat untuk keperluan export CSV/Excel.
     *
     * @param array $filters
     * @return Collection
     */
    public function getExportData(array $filters = []): Collection
    {
        $query = Pelatihan::with(['kategori', 'pendaftaran.user', 'pendaftaran.kehadiran']);

        if (!empty($filters['tahun'])) {
            $query->whereYear('tanggal', $filters['tahun']);
        }
        if (!empty($filters['bulan'])) {
            $query->whereMonth('tanggal', $filters['bulan']);
        }
        if (!empty($filters['kategori_id'])) {
            $query->where('kategori_id', $filters['kategori_id']);
        }

        $pelatihans = $query->latest('tanggal')->get();

        return $pelatihans->map(function ($p) {
            return [
                'Pelatihan' => $p->judul,
                'Kategori' => $p->kategori->nama_kategori,
                'Tanggal' => $p->tanggal->format('d/m/Y'),
                'Total Pendaftar' => $p->pendaftaran->count(),
                'Disetujui' => $p->pendaftaran->where('status', 'disetujui')->count(),
                'Ditolak' => $p->pendaftaran->where('status', 'ditolak')->count(),
                'Hadir' => $p->pendaftaran->filter(fn($pendaftar) => $pendaftar->kehadiran && $pendaftar->kehadiran->status_kehadiran === 'hadir')->count(),
            ];
        });
    }

    /**
     * Mendapatkan data mentah laporan pelatihan terfilter.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLaporanData(array $filters = [])
    {
        $query = Pelatihan::with(['kategori', 'pendaftaran.user', 'pendaftaran.kehadiran']);

        if (!empty($filters['tahun'])) {
            $query->whereYear('tanggal', $filters['tahun']);
        }
        if (!empty($filters['bulan'])) {
            $query->whereMonth('tanggal', $filters['bulan']);
        }
        if (!empty($filters['kategori_id'])) {
            $query->where('kategori_id', $filters['kategori_id']);
        }

        return $query->latest('tanggal')->get();
    }

    /**
     * Membuat instance PDF Laporan Perkembangan Pelatihan.
     *
     * @param array $filters
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generatePdf(array $filters = [])
    {
        $pelatihans = $this->getLaporanData($filters);

        // Calculate summary stats
        $totalPelatihan = $pelatihans->count();
        $totalPendaftar = 0;
        $totalDisetujui = 0;
        $totalHadir = 0;

        foreach ($pelatihans as $p) {
            $totalPendaftar += $p->pendaftaran->count();
            $totalDisetujui += $p->pendaftaran->where('status', 'disetujui')->count();
            $totalHadir += $p->pendaftaran->filter(fn($pendaftar) => $pendaftar->kehadiran && $pendaftar->kehadiran->status_kehadiran === 'hadir')->count();
        }

        $selectedKategori = null;
        if (!empty($filters['kategori_id'])) {
            $selectedKategori = \App\Models\KategoriPelatihan::find($filters['kategori_id']);
        }

        return Pdf::loadView('pdf.laporan', compact(
            'pelatihans',
            'filters',
            'totalPelatihan',
            'totalPendaftar',
            'totalDisetujui',
            'totalHadir',
            'selectedKategori'
        ));
    }
}
