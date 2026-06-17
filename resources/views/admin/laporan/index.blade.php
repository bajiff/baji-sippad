@extends('layouts.admin')

@section('title', 'Laporan')
@section('header', 'Laporan & Statistik')

@section('content')
<div class="card p-6 mb-6">
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Bulan</label>
            <select name="bulan" class="px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <option value="">Semua</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m)) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Tahun</label>
            <select name="tahun" class="px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <option value="">Semua</option>
                @foreach(range(2025, 2030) as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-[var(--color-surface-2)] text-[var(--color-ink)] rounded text-sm font-medium hover:bg-[var(--color-border)]">Filter</button>
        <a href="{{ route('admin.laporan.export', 'csv') }}" class="px-4 py-2 bg-[var(--color-success)] text-white rounded text-sm font-medium hover:bg-green-700">Export CSV</a>
    </form>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[var(--color-surface-1)]">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Kategori</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Tanggal</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Total</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Disetujui</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Ditolak</th>
                <th class="text-right px-4 py-3 font-medium text-[var(--color-ink-muted)]">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--color-border)]">
            @forelse($pelatihans as $p)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $p->judul }}</td>
                    <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $p->kategori->nama_kategori }}</td>
                    <td class="px-4 py-3">{{ $p->tanggal->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $p->pendaftaran_count }}</td>
                    <td class="px-4 py-3 text-[var(--color-success)]">{{ $p->disetujui_count }}</td>
                    <td class="px-4 py-3 text-[var(--color-danger)]">{{ $p->ditolak_count }}</td>
                    <td class="px-4 py-3 text-right">
                        @if($p->sertifikat_enabled)
                            <form method="POST" action="{{ route('admin.sertifikat.generate', $p) }}" onsubmit="return confirm('Generate sertifikat untuk semua peserta hadir?')">
                                @csrf
                                <button type="submit" class="text-[var(--color-link)] hover:underline text-sm">Generate Sertifikat</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $pelatihans->links() }}</div>
@endsection
