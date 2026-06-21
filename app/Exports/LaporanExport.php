<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanExport implements FromView, ShouldAutoSize, WithTitle
{
    protected $pelatihans;
    protected $filters;
    protected $totalPelatihan;
    protected $totalPendaftar;
    protected $totalDisetujui;
    protected $totalHadir;

    public function __construct($pelatihans, $filters, $totalPelatihan, $totalPendaftar, $totalDisetujui, $totalHadir)
    {
        $this->pelatihans = $pelatihans;
        $this->filters = $filters;
        $this->totalPelatihan = $totalPelatihan;
        $this->totalPendaftar = $totalPendaftar;
        $this->totalDisetujui = $totalDisetujui;
        $this->totalHadir = $totalHadir;
    }

    public function view(): View
    {
        return view('excel.laporan', [
            'pelatihans' => $this->pelatihans,
            'filters' => $this->filters,
            'totalPelatihan' => $this->totalPelatihan,
            'totalPendaftar' => $this->totalPendaftar,
            'totalDisetujui' => $this->totalDisetujui,
            'totalHadir' => $this->totalHadir,
        ]);
    }

    public function title(): string
    {
        return 'Laporan Pelatihan';
    }
}
