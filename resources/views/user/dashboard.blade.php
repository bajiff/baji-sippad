@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-6">Selamat datang, {{ auth()->user()->name }}!</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="card p-5">
            <p class="text-sm text-[var(--color-ink-muted)]">Terdaftar</p>
            <p class="text-3xl font-bold text-[var(--color-ink)] mt-1">{{ $stats['terdaftar'] }}</p>
        </div>
        <div class="card p-5">
            <p class="text-sm text-[var(--color-ink-muted)]">Disetujui</p>
            <p class="text-3xl font-bold text-[var(--color-success)] mt-1">{{ $stats['disetujui'] }}</p>
        </div>
        <div class="card p-5">
            <p class="text-sm text-[var(--color-ink-muted)]">Menunggu</p>
            <p class="text-3xl font-bold text-[var(--color-warning)] mt-1">{{ $stats['pending'] }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div>
            <h2 class="text-lg font-semibold text-[var(--color-ink)] mb-4">Pelatihan Terbaru</h2>
            <div class="space-y-3">
                @forelse($pelatihanAktif as $p)
                    <div class="card p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-medium text-[var(--color-ink)]">{{ $p->judul }}</h3>
                                <p class="text-xs text-[var(--color-ink-muted)] mt-1">{{ $p->kategori->nama_kategori }} &middot; {{ $p->tanggal->format('d M Y') }}</p>
                            </div>
                            <a href="{{ route('user.pelatihan.show', $p) }}" class="text-[var(--color-link)] text-sm hover:underline">Lihat</a>
                        </div>
                    </div>
                @empty
                    <div class="card p-8 text-center text-[var(--color-ink-muted)]">Tidak ada pelatihan aktif</div>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold text-[var(--color-ink)] mb-4">Pendaftaran Saya</h2>
            <div class="space-y-3">
                @forelse($pendaftaranSaya as $p)
                    <div class="card p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-medium text-[var(--color-ink)]">{{ $p->pelatihan->judul }}</h3>
                                <p class="text-xs text-[var(--color-ink-muted)] mt-1">{{ $p->tanggal_daftar->format('d M Y') }}</p>
                            </div>
                            @if($p->status === 'pending')
                                <x-badge variant="warning">Menunggu</x-badge>
                            @elseif($p->status === 'disetujui')
                                <x-badge variant="success">Disetujui</x-badge>
                            @else
                                <x-badge variant="danger">Ditolak</x-badge>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card p-8 text-center text-[var(--color-ink-muted)]">Belum ada pendaftaran</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
