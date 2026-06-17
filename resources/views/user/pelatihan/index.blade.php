@extends('layouts.user')

@section('title', 'Pelatihan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-6">Pelatihan Tersedia</h1>

    <form method="GET" class="flex flex-wrap items-end gap-4 mb-6">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelatihan..."
                   class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
        </div>
        <div>
            <select name="kategori_id" class="px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-[var(--color-surface-2)] text-[var(--color-ink)] rounded text-sm font-medium hover:bg-[var(--color-border)]">Cari</button>
    </form>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($pelatihans as $p)
            <div class="card overflow-hidden">
                <div class="h-40 bg-[var(--color-surface-1)] flex items-center justify-center">
                    <svg class="w-12 h-12 text-[var(--color-border)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <x-badge>{{ $p->kategori->nama_kategori }}</x-badge>
                    </div>
                    <h3 class="font-semibold text-[var(--color-ink)] mb-2">{{ $p->judul }}</h3>
                    <p class="text-sm text-[var(--color-ink-muted)] mb-3">{{ Str::limit($p->deskripsi, 80) }}</p>
                    <div class="flex items-center justify-between text-xs text-[var(--color-ink-muted)]">
                        <span>{{ $p->tanggal->format('d M Y') }}</span>
                        <span>{{ $p->jam }}</span>
                    </div>
                    <a href="{{ route('user.pelatihan.show', $p) }}" class="mt-4 block text-center py-2 bg-[var(--color-surface-1)] text-[var(--color-ink)] rounded text-sm font-medium hover:bg-[var(--color-surface-2)] transition-colors">Lihat Detail</a>
                </div>
            </div>
        @empty
            <div class="col-span-full card p-12 text-center text-[var(--color-ink-muted)]">Tidak ada pelatihan ditemukan</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $pelatihans->links() }}</div>
</div>
@endsection
