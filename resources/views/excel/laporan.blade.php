<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40" lang="id">
<head>
    <meta charset="UTF-8">
    <!--[if gte mso 9]>
    <xml>
        {!! '<' . 'x:ExcelWorkbook>' !!}
            {!! '<' . 'x:ExcelWorksheets>' !!}
                {!! '<' . 'x:ExcelWorksheet>' !!}
                    {!! '<' . 'x:Name>Laporan Pelatihan SIPPAD</' . 'x:Name>' !!}
                    {!! '<' . 'x:WorksheetOptions>' !!}
                        {!! '<' . 'x:DisplayGridlines/>' !!}
                    {!! '</' . 'x:WorksheetOptions>' !!}
                {!! '</' . 'x:ExcelWorksheet>' !!}
            {!! '</' . 'x:ExcelWorksheets>' !!}
        {!! '</' . 'x:ExcelWorkbook>' !!}
    </xml>
    <![endif]-->
    <style>
        table {
            border-collapse: collapse;
        }
        .title {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 16pt;
            font-weight: bold;
            color: #1e3a8a;
        }
        .subtitle {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 10pt;
            color: #4b5563;
        }
        .meta-info {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 9pt;
            color: #6b7280;
        }
        .stats-label {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 9pt;
            font-weight: bold;
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 6px;
            text-align: center;
        }
        .stats-value {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12pt;
            font-weight: bold;
            color: #059669;
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            padding: 6px;
            text-align: center;
        }
        th {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 10pt;
            background-color: #059669; /* Emerald Green */
            color: #ffffff;
            font-weight: bold;
            border: 1px solid #d1d5db;
            padding: 8px 6px;
            text-align: left;
        }
        td {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 9.5pt;
            border: 1px solid #d1d5db;
            padding: 6px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            background-color: #e5e7eb;
            border-top: 2px solid #9ca3af;
            border-bottom: 2px double #9ca3af;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <table>
        <tr>
            <td colspan="8" class="title">LAPORAN PERKEMBANGAN PELATIHAN</td>
        </tr>
        <tr>
            <td colspan="8" class="subtitle">Sistem Pendaftaran Pelatihan Anak Desa (SIPPAD) · Desa Sari Mukti</td>
        </tr>
        <tr>
            <td colspan="8" class="meta-info">
                <strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y H:i') }} WIB | 
                <strong>Filter:</strong> 
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
                        $kategori = \App\Models\KategoriPelatihan::find($filters['kategori_id']);
                        if ($kategori) $applied[] = "Kategori: " . $kategori->nama_kategori;
                    }
                @endphp
                {{ count($applied) > 0 ? implode(', ', $applied) : 'Semua Data' }}
            </td>
        </tr>
        <!-- Empty row for spacing -->
        <tr><td colspan="8"></td></tr>
    </table>

    <!-- Ringkasan Statistik -->
    <table>
        <tr>
            <td colspan="2" class="stats-label">Total Pelatihan</td>
            <td colspan="2" class="stats-label">Total Pendaftar</td>
            <td colspan="2" class="stats-label">Peserta Disetujui</td>
            <td colspan="2" class="stats-label">Peserta Hadir</td>
        </tr>
        <tr>
            <td colspan="2" class="stats-value">{{ $totalPelatihan }}</td>
            <td colspan="2" class="stats-value">{{ $totalPendaftar }}</td>
            <td colspan="2" class="stats-value">{{ $totalDisetujui }}</td>
            <td colspan="2" class="stats-value">{{ $totalHadir }}</td>
        </tr>
        <!-- Empty row for spacing -->
        <tr><td colspan="8"></td></tr>
    </table>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 50px;" class="text-center">No</th>
                <th style="width: 250px;">Judul Pelatihan</th>
                <th style="width: 150px;">Kategori</th>
                <th style="width: 100px;">Tanggal</th>
                <th style="width: 80px;" class="text-center">Pendaftar</th>
                <th style="width: 80px;" class="text-center">Disetujui</th>
                <th style="width: 80px;" class="text-center">Hadir</th>
                <th style="width: 80px;" class="text-center">Status</th>
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
                    <td>{{ $p->tanggal->translatedFormat('d/m/Y') }}</td>
                    <td class="text-center">{{ $pendaftarCount }}</td>
                    <td class="text-center">{{ $disetujuiCount }}</td>
                    <td class="text-center">{{ $hadirCount }}</td>
                    <td class="text-center" style="text-transform: capitalize;">{{ $p->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #6b7280;">Tidak ada data pelatihan ditemukan.</td>
                </tr>
            @endforelse
            
            <!-- Summary Row -->
            @if($pelatihans->isNotEmpty())
                <tr class="total-row">
                    <td colspan="4" class="text-right">TOTAL</td>
                    <td class="text-center">{{ $totalPendaftar }}</td>
                    <td class="text-center">{{ $totalDisetujui }}</td>
                    <td class="text-center">{{ $totalHadir }}</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
