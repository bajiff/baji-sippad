@extends('layouts.user')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-6">Status Pendaftaran</h1>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[var(--color-surface-1)]">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Kategori</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Tanggal Daftar</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Status</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)] w-1/3">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-border)]">
                @forelse($pendaftarans as $p)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $p->pelatihan->judul }}</td>
                        <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $p->pelatihan->kategori->nama_kategori }}</td>
                        <td class="px-4 py-3">{{ $p->tanggal_daftar->format('d M Y') }}</td>
                        <td class="px-4 py-3 align-top">
                            @if($p->status === 'pending')
                                <x-badge variant="warning">Menunggu</x-badge>
                            @elseif($p->status === 'disetujui')
                                <x-badge variant="success">Disetujui</x-badge>
                            @else
                                <x-badge variant="danger">Ditolak</x-badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 align-top">
                            @if($p->status === 'pending')
                                <p class="text-sm text-[var(--color-ink-muted)] italic">Sedang diverifikasi oleh tim admin.</p>
                            @elseif($p->status === 'disetujui')
                                <p class="text-sm text-green-600 font-medium">Silakan cek menu Riwayat Pelatihan.</p>
                            @else
                                @if($p->alasan_penolakan)
                                    <p class="text-sm text-red-600 leading-relaxed">{{ $p->alasan_penolakan }}</p>
                                @else
                                    <p class="text-sm text-red-600 italic">Ditolak (Tanpa keterangan tambahan).</p>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Belum ada pendaftaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $pendaftarans->links() }}</div>
</div>
@endsection
