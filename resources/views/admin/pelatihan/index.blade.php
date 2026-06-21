@extends('layouts.admin')

@section('title', 'Pelatihan')
@section('header', 'Manajemen Pelatihan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-[var(--color-ink-muted)]">Total: {{ $pelatihans->total() }} pelatihan</p>
    <a href="{{ route('admin.pelatihan.create') }}" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)] transition-colors">
        + Tambah Pelatihan
    </a>
</div>

<div class="card">
    <table class="w-full text-sm">
        <thead class="bg-[var(--color-surface-1)]">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)] rounded-tl-lg">Judul</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Kategori</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Tanggal</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Kuota</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Status</th>
                <th class="text-right px-4 py-3 font-medium text-[var(--color-ink-muted)] rounded-tr-lg">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--color-border)]">
            @forelse($pelatihans as $p)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $p->judul }}</td>
                    <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $p->kategori->nama_kategori }}</td>
                    <td class="px-4 py-3">{{ $p->tanggal->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $p->kuota ?? '∞' }}</td>
                    <td class="px-4 py-3">
                        @if($p->status === 'draft')
                            <x-badge variant="default">Draft</x-badge>
                        @elseif($p->status === 'publish')
                            <x-badge variant="success">Publish</x-badge>
                        @elseif($p->status === 'closed')
                            <x-badge variant="danger">Closed</x-badge>
                        @else
                            <x-badge variant="info">Selesai</x-badge>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <div x-data="{ open: false }" class="relative inline-block">
                                <button @click="open = !open" class="text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] text-sm">Status ▾</button>
                                <div x-show="open" @click.outside="open = false" class="absolute right-0 w-36 bg-[var(--color-canvas)] border border-[var(--color-border)] rounded shadow-lg z-20 {{ $loop->last ? 'bottom-full mb-1' : 'mt-1' }}">
                                    @foreach(['draft' => 'Draft', 'publish' => 'Publish', 'closed' => 'Closed', 'selesai' => 'Selesai'] as $val => $label)
                                        <form method="POST" action="{{ route('admin.pelatihan.updateStatus', $p) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $val }}">
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-[var(--color-surface-1)]">{{ $label }}</button>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                            <a href="{{ route('admin.pelatihan.edit', $p) }}" class="text-[var(--color-link)] hover:underline text-sm">Edit</a>
                            @if(in_array($p->status, ['publish', 'selesai']))
                                <a href="{{ route('admin.kehadiran.show', $p) }}" class="text-[var(--color-success)] hover:underline text-sm">Presensi</a>
                            @endif
                            <form method="POST" action="{{ route('admin.pelatihan.destroy', $p) }}" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[var(--color-danger)] hover:underline text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Belum ada pelatihan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $pelatihans->links() }}</div>
@endsection
