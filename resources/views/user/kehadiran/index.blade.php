@extends('layouts.user')

@section('title', 'Presensi Kehadiran')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-6">Presensi Kehadiran</h1>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[var(--color-surface-1)]">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Kategori</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Tanggal & Jam</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Status Presensi</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Aksi / Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-border)]">
                @forelse($pendaftarans as $p)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $p->pelatihan->judul }}</td>
                        <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $p->pelatihan->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-4 py-3">
                            {{ $p->pelatihan->tanggal ? $p->pelatihan->tanggal->format('d M Y') : '-' }}
                            @if($p->pelatihan->jam)
                                <span class="text-xs text-[var(--color-ink-muted)] block">{{ $p->pelatihan->jam }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 align-top">
                            @if($p->kehadiran && $p->kehadiran->status_kehadiran === 'hadir')
                                <x-badge variant="success">Hadir</x-badge>
                            @elseif($p->kehadiran && $p->kehadiran->status_kehadiran === 'tidak_hadir')
                                <x-badge variant="danger">Tidak Hadir</x-badge>
                            @else
                                <x-badge variant="warning">Belum Presensi</x-badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 align-top">
                            @if($p->kehadiran && $p->kehadiran->status_kehadiran)
                                <p class="text-sm text-green-600 font-medium">Presensi berhasil dicatat.</p>
                            @else
                                @if(in_array($p->pelatihan->status, ['publish', 'selesai']))
                                    @if($p->pelatihan->presensi_by === 'peserta')
                                        <form method="POST" action="{{ route('user.kehadiran.store', $p) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-[var(--color-primary)] text-white text-xs font-medium rounded hover:bg-[var(--color-primary-hover)] transition-colors">
                                                Presensi Hadir
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-sm text-[var(--color-ink-muted)] italic">Presensi dilakukan oleh Admin</p>
                                    @endif
                                @else
                                    <p class="text-sm text-[var(--color-ink-muted)] italic">Pelatihan belum aktif / ditutup</p>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Belum ada pelatihan yang disetujui untuk presensi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $pendaftarans->links() }}</div>
</div>
@endsection
