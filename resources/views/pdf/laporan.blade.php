<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pelatihan SIPPAD</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1b1b1b;
            font-size: 11px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #1b1b1b;
            padding-bottom: 10px;
        }
        .logo {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #e68600;
            margin-bottom: 5px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 12px;
            color: #6e6e6e;
            margin-top: 5px;
        }
        .meta-info {
            width: 100%;
            margin-bottom: 20px;
        }
        .meta-col-left {
            width: 60%;
            font-size: 10px;
            color: #6e6e6e;
        }
        .meta-col-right {
            width: 40%;
            text-align: right;
            font-size: 10px;
            color: #6e6e6e;
        }
        .filters-badge {
            display: inline-block;
            background: #F5F5F5;
            border: 1px solid #D3D3D3;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 9px;
            color: #1b1b1b;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 25px;
            border-spacing: 10px 0;
            margin-left: -10px;
            margin-right: -10px;
        }
        .stats-card {
            background: #F5F5F5;
            border: 1px solid #D3D3D3;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
            width: 25%;
        }
        .stats-val {
            font-size: 16px;
            font-weight: bold;
            color: #e68600;
            margin-bottom: 2px;
        }
        .stats-lbl {
            font-size: 8px;
            color: #6e6e6e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th {
            background-color: #1b1b1b;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 8px 6px;
            border: 1px solid #1b1b1b;
            text-align: left;
        }
        .table td {
            padding: 8px 6px;
            border: 1px solid #D3D3D3;
            font-size: 9px;
            vertical-align: middle;
        }
        .table tr:nth-child(even) td {
            background-color: #F9F9F9;
        }
        .signature-table {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-col {
            width: 50%;
        }
        .signature-box {
            text-align: center;
            width: 200px;
            margin: 0 auto;
        }
        .signature-line {
            width: 100%;
            border-bottom: 1px solid #6e6e6e;
            margin-top: 60px;
            margin-bottom: 5px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">SIPPAD</div>
        <h1 class="title">Laporan Perkembangan Pelatihan</h1>
        <div class="subtitle">Sistem Pendaftaran Pelatihan Anak Desa · Pemerintah Desa Sari Mukti</div>
    </div>

    <table class="meta-info">
        <tr>
            <td class="meta-col-left">
                <strong>Filter Diterapkan:</strong> 
                @php
                    $applied = [];
                    if (!empty($filters['tahun'])) $applied[] = "Tahun: " . $filters['tahun'];
                    if (!empty($filters['bulan'])) {
                        $monthNames = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $applied[] = "Bulan: " . ($monthNames[(int)$filters['bulan']] ?? $filters['bulan']);
                    }
                    if (!empty($filters['kategori_id'])) {
                        $kategori = $selectedKategori ?? \App\Models\KategoriPelatihan::find($filters['kategori_id']);
                        if ($kategori) $applied[] = "Kategori: " . $kategori->nama_kategori;
                    }
                @endphp
                @if(count($applied) > 0)
                    <span class="filters-badge">{{ implode(', ', $applied) }}</span>
                @else
                    <span class="filters-badge">Semua Data (Tanpa Filter)</span>
                @endif
            </td>
            <td class="meta-col-right">
                Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }} WIB
            </td>
        </tr>
    </table>

    <!-- Ringkasan Statistik -->
    <table class="stats-grid">
        <tr>
            <td class="stats-card">
                <div class="stats-val">{{ $totalPelatihan }}</div>
                <div class="stats-lbl">Total Pelatihan</div>
            </td>
            <td class="stats-card">
                <div class="stats-val">{{ $totalPendaftar }}</div>
                <div class="stats-lbl">Total Pendaftar</div>
            </td>
            <td class="stats-card">
                <div class="stats-val">{{ $totalDisetujui }}</div>
                <div class="stats-lbl">Peserta Disetujui</div>
            </td>
            <td class="stats-card">
                <div class="stats-val">{{ $totalHadir }}</div>
                <div class="stats-lbl">Peserta Hadir</div>
            </td>
        </tr>
    </table>

    <!-- Tabel Pelatihan -->
    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 30%;">Judul Pelatihan</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 13%;">Tanggal</th>
                <th style="width: 10%;" class="text-center">Pendaftar</th>
                <th style="width: 10%;" class="text-center">Disetujui</th>
                <th style="width: 10%;" class="text-center">Hadir</th>
                <th style="width: 7%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelatihans as $index => $p)
                @php
                    $pendaftarCount = $p->pendaftaran->count();
                    $disetujuiCount = $p->pendaftaran->where('status', 'disetujui')->count();
                    $hadirCount = $p->pendaftaran->filter(fn($pendaftar) => $pendaftar->kehadiran && $pendaftar->kehadiran->status_kehadiran === 'hadir')->count();
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $p->judul }}</td>
                    <td>{{ $p->kategori->nama_kategori }}</td>
                    <td>{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                    <td class="text-center">{{ $pendaftarCount }}</td>
                    <td class="text-center">{{ $disetujuiCount }}</td>
                    <td class="text-center">{{ $hadirCount }}</td>
                    <td class="text-center" style="text-transform: capitalize;">{{ $p->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #6e6e6e;">Tidak ada data pelatihan ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <table class="signature-table">
        <tr>
            <td class="signature-col"></td>
            <td class="signature-col">
                <div class="signature-box">
                    <div>Desa Sari Mukti, {{ now()->translatedFormat('d F Y') }}</div>
                    <div style="font-weight: bold; margin-top: 5px;">Kepala Desa Sari Mukti</div>
                    <div class="signature-line"></div>
                    <div style="font-weight: bold;">Pemerintah Desa Sari Mukti</div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
