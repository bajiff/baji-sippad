@extends('layouts.admin')

@section('title', 'Presensi - ' . $pelatihan->judul)
@section('header', 'Presensi: ' . $pelatihan->judul)

@section('content')
<div class="card p-4 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h4 class="font-medium text-[var(--color-ink)]">Metode Presensi Pelatihan</h4>
        <p class="text-xs text-[var(--color-ink-muted)]">Tentukan siapa yang dapat mencatatkan presensi kehadiran peserta.</p>
    </div>
    <form method="POST" action="{{ route('admin.kehadiran.toggleMode', $pelatihan) }}" class="flex items-center gap-2">
        @csrf @method('PATCH')
        <div class="inline-flex rounded-md shadow-sm" role="group">
            <button type="submit" name="presensi_by" value="admin" 
                class="px-4 py-2 text-xs font-semibold rounded-l-md border {{ $pelatihan->presensi_by === 'admin' ? 'bg-[var(--color-primary)] text-[var(--color-on-primary)] border-[var(--color-primary)]' : 'bg-[var(--color-canvas)] text-[var(--color-ink-muted)] border-[var(--color-border)] hover:bg-[var(--color-surface-1)]' }} transition-colors">
                Oleh Admin
            </button>
            <button type="submit" name="presensi_by" value="peserta" 
                class="px-4 py-2 text-xs font-semibold rounded-r-md border {{ $pelatihan->presensi_by === 'peserta' ? 'bg-[var(--color-primary)] text-[var(--color-on-primary)] border-[var(--color-primary)]' : 'bg-[var(--color-canvas)] text-[var(--color-ink-muted)] border-[var(--color-border)] hover:bg-[var(--color-surface-1)]' }} border-l-0 transition-colors">
                Oleh Peserta Mandiri
            </button>
        </div>
    </form>
</div>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[var(--color-surface-1)]">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Nama</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Email</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Status Kehadiran</th>
                <th class="text-right px-4 py-3 font-medium text-[var(--color-ink-muted)]">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--color-border)]">
            @forelse($pendaftarans as $p)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $p->user->name }}</td>
                    <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $p->user->email }}</td>
                    <td class="px-4 py-3">
                        @if($p->kehadiran)
                            @if($p->kehadiran->status_kehadiran === 'hadir')
                                <x-badge variant="success">Hadir</x-badge>
                            @else
                                <x-badge variant="danger">Tidak Hadir</x-badge>
                            @endif
                        @else
                            <x-badge variant="default">Belum Presensi</x-badge>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="{{ route('admin.kehadiran.update', $p) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status_kehadiran" value="hadir">
                                <button type="submit" class="px-3 py-1 bg-[var(--color-success)] text-white rounded text-xs font-medium hover:bg-green-700">Hadir</button>
                            </form>
                            <form method="POST" action="{{ route('admin.kehadiran.update', $p) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status_kehadiran" value="tidak_hadir">
                                <button type="submit" class="px-3 py-1 bg-[var(--color-danger)] text-white rounded text-xs font-medium hover:bg-red-700">Tidak Hadir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Tidak ada peserta</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
