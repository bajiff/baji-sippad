@extends('layouts.admin')

@section('title', 'Kategori Pelatihan')
@section('header', 'Kategori Pelatihan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-[var(--color-ink-muted)]">Total: {{ $kategoris->total() }} kategori</p>
    <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)] transition-colors">
        + Tambah Kategori
    </a>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[var(--color-surface-1)]">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">#</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Nama Kategori</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Deskripsi</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan</th>
                <th class="text-right px-4 py-3 font-medium text-[var(--color-ink-muted)]">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--color-border)]">
            @forelse($kategoris as $kategori)
                <tr>
                    <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $kategoris->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-3 font-medium">{{ $kategori->nama_kategori }}</td>
                    <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ Str::limit($kategori->deskripsi, 50) }}</td>
                    <td class="px-4 py-3">{{ $kategori->pelatihan_count }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.kategori.edit', $kategori) }}" class="text-[var(--color-link)] hover:underline text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.kategori.destroy', $kategori) }}" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[var(--color-danger)] hover:underline text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Belum ada kategori</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $kategoris->links() }}</div>
@endsection
