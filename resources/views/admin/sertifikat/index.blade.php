@extends('layouts.admin')

@section('title', 'Sertifikat')
@section('header', 'Manajemen Sertifikat')

@section('content')
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[var(--color-surface-1)]">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">No. Sertifikat</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Peserta</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Tanggal Terbit</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--color-border)]">
            @forelse($sertifikats as $s)
                <tr>
                    <td class="px-4 py-3 font-mono text-xs">{{ $s->nomor_sertifikat }}</td>
                    <td class="px-4 py-3">{{ $s->kehadiran->pendaftaran->user->name }}</td>
                    <td class="px-4 py-3">{{ $s->kehadiran->pendaftaran->pelatihan->judul }}</td>
                    <td class="px-4 py-3">{{ $s->tanggal_terbit->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Belum ada sertifikat</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $sertifikats->links() }}</div>
@endsection
