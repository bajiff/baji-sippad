@extends('layouts.user')

@section('title', 'Riwayat Pelatihan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-6">Riwayat Pelatihan</h1>

    <div class="space-y-4">
        @forelse($riwayat as $r)
            <div class="card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-[var(--color-ink)]">{{ $r->pelatihan->judul }}</h3>
                        <p class="text-sm text-[var(--color-ink-muted)] mt-1">{{ $r->pelatihan->kategori->nama_kategori }} &middot; {{ $r->pelatihan->tanggal->format('d M Y') }}</p>
                    </div>
                    @if($r->kehadiran && $r->kehadiran->status_kehadiran === 'hadir')
                        <x-badge variant="success">Hadir</x-badge>
                    @elseif($r->kehadiran)
                        <x-badge variant="danger">Tidak Hadir</x-badge>
                    @else
                        <x-badge variant="default">—</x-badge>
                    @endif
                </div>
                @if($r->kehadiran && $r->kehadiran->sertifikat)
                    <div class="mt-3 pt-3 border-t border-[var(--color-border)]">
                        <p class="text-xs text-[var(--color-ink-muted)]">Sertifikat: {{ $r->kehadiran->sertifikat->nomor_sertifikat }}</p>
                        <a href="{{ route('user.sertifikat.download', $r->kehadiran->sertifikat) }}" class="text-[var(--color-link)] text-sm hover:underline">Download Sertifikat</a>
                    </div>
                @endif
            </div>
        @empty
            <div class="card p-12 text-center text-[var(--color-ink-muted)]">Belum ada riwayat pelatihan</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $riwayat->links() }}</div>
</div>
@endsection
