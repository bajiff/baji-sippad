@extends('layouts.admin')

@section('title', 'Absensi - ' . $pelatihan->judul)
@section('header', 'Absensi: ' . $pelatihan->judul)

@section('content')
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
                            <x-badge variant="default">Belum Diabsen</x-badge>
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
