@extends('layouts.admin')

@section('title', 'Dokumentasi')
@section('header', 'Dokumentasi Kegiatan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-[var(--color-ink-muted)]">Total: {{ $dokumentasis->total() }} foto</p>
    <a href="{{ route('admin.dokumentasi.create') }}" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)] transition-colors">
        + Upload Foto
    </a>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($dokumentasis as $d)
        <div class="card overflow-hidden">
            <div class="aspect-square bg-[var(--color-surface-1)] flex items-center justify-center">
                <img src="{{ Storage::url($d->foto_kegiatan) }}" alt="Dokumentasi" class="w-full h-full object-cover">
            </div>
            <div class="p-3">
                <p class="text-xs font-medium text-[var(--color-ink)]">{{ Str::limit($d->pelatihan->judul, 30) }}</p>
                <p class="text-xs text-[var(--color-ink-muted)] mt-1">{{ $d->created_at->format('d M Y') }}</p>
                <form method="POST" action="{{ route('admin.dokumentasi.destroy', $d) }}" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="mt-2 text-xs text-[var(--color-danger)] hover:underline">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full card p-8 text-center text-[var(--color-ink-muted)]">Belum ada dokumentasi</div>
    @endforelse
</div>

<div class="mt-4">{{ $dokumentasis->links() }}</div>
@endsection
