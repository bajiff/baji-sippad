@extends('layouts.admin')

@section('title', 'Verifikasi Pendaftaran')
@section('header', 'Verifikasi Pendaftaran')

@section('content')
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[var(--color-surface-1)]">
            <tr>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Nama</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Email</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Tanggal Daftar</th>
                <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Status</th>
                <th class="text-right px-4 py-3 font-medium text-[var(--color-ink-muted)]">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--color-border)]">
            @forelse($pendaftarans as $p)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $p->user->name }}</td>
                    <td class="px-4 py-3 text-[var(--color-ink-muted)]">{{ $p->user->email }}</td>
                    <td class="px-4 py-3">{{ $p->pelatihan->judul }}</td>
                    <td class="px-4 py-3">{{ $p->tanggal_daftar->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        @if($p->status === 'pending')
                            <x-badge variant="warning">Menunggu</x-badge>
                        @elseif($p->status === 'disetujui')
                            <x-badge variant="success">Disetujui</x-badge>
                        @else
                            <x-badge variant="danger">Ditolak</x-badge>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        @if($p->status === 'pending')
                            <div class="flex items-center justify-end gap-2">
                                <form method="POST" action="{{ route('admin.pendaftaran.setujui', $p) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-[var(--color-success)] text-white rounded text-xs font-medium hover:bg-green-700">Setujui</button>
                                </form>
                                <form method="POST" action="{{ route('admin.pendaftaran.tolak', $p) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-[var(--color-danger)] text-white rounded text-xs font-medium hover:bg-red-700">Tolak</button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-[var(--color-ink-muted)]">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-[var(--color-ink-muted)]">Belum ada pendaftaran</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $pendaftarans->links() }}</div>
@endsection
