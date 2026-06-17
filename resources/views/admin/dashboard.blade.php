@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="card p-5">
        <p class="text-sm text-[var(--color-ink-muted)]">Total Peserta</p>
        <p class="text-3xl font-bold text-[var(--color-ink)] mt-1">{{ $stats['total_peserta'] }}</p>
    </div>
    <div class="card p-5">
        <p class="text-sm text-[var(--color-ink-muted)]">Pelatihan Aktif</p>
        <p class="text-3xl font-bold text-[var(--color-success)] mt-1">{{ $stats['pelatihan_aktif'] }}</p>
    </div>
    <div class="card p-5">
        <p class="text-sm text-[var(--color-ink-muted)]">Menunggu Verifikasi</p>
        <p class="text-3xl font-bold text-[var(--color-warning)] mt-1">{{ $stats['menunggu_verifikasi'] }}</p>
    </div>
    <div class="card p-5">
        <p class="text-sm text-[var(--color-ink-muted)]">Pelatihan Selesai</p>
        <p class="text-3xl font-bold text-[var(--color-info)] mt-1">{{ $stats['pelatihan_selesai'] }}</p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div>
        <h3 class="text-lg font-semibold text-[var(--color-ink)] mb-4">Pendaftaran Terbaru</h3>
        <div class="card overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[var(--color-surface-1)]">
                    <tr>
                        <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Nama</th>
                        <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan</th>
                        <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--color-border)]">
                    @forelse($recentPendaftaran as $p)
                        <tr>
                            <td class="px-4 py-3">{{ $p->user->name }}</td>
                            <td class="px-4 py-3">{{ Str::limit($p->pelatihan->judul, 30) }}</td>
                            <td class="px-4 py-3">
                                @if($p->status === 'pending')
                                    <x-badge variant="warning">Menunggu</x-badge>
                                @elseif($p->status === 'disetujui')
                                    <x-badge variant="success">Disetujui</x-badge>
                                @else
                                    <x-badge variant="danger">Ditolak</x-badge>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Belum ada pendaftaran</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-semibold text-[var(--color-ink)] mb-4">Pelatihan Aktif</h3>
        <div class="space-y-3">
            @forelse($pelatihanAktif as $p)
                <div class="card p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="font-medium text-[var(--color-ink)]">{{ $p->judul }}</h4>
                            <p class="text-xs text-[var(--color-ink-muted)] mt-1">{{ $p->kategori->nama_kategori }} &middot; {{ $p->tanggal->format('d M Y') }}</p>
                        </div>
                        <x-badge variant="info">Publish</x-badge>
                    </div>
                </div>
            @empty
                <div class="card p-8 text-center text-[var(--color-ink-muted)]">Tidak ada pelatihan aktif</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
