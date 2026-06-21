@extends('layouts.admin')

@section('title', 'Kehadiran')
@section('header', 'Manajemen Kehadiran')

@section('content')
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[var(--color-surface-1)]">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Kategori</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Tanggal</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Peserta Disetujui</th>
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
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.kehadiran.show', $p) }}" class="text-[var(--color-link)] hover:underline text-sm">Kelola Presensi</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Belum ada pelatihan aktif atau selesai</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $pelatihans->links() }}</div>
@endsection
