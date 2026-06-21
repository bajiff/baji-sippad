@extends('layouts.admin')

@section('title', 'Sertifikat')
@section('header', 'Manajemen Sertifikat')

@section('content')
<div class="card overflow-hidden">
    <div class="p-6 border-b border-[var(--color-border)]">
        <h3 class="text-base font-semibold text-[var(--color-ink)]">Daftar Pelatihan</h3>
        <p class="text-xs text-[var(--color-ink-muted)] mt-1">Pilih pelatihan di bawah ini untuk mengelola dan menerbitkan sertifikat peserta secara massal atau individu.</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[var(--color-surface-1)]">
                <tr>
                    <th class="text-left px-6 py-3.5 font-medium text-[var(--color-ink-muted)]">Nama Pelatihan</th>
                    <th class="text-left px-6 py-3.5 font-medium text-[var(--color-ink-muted)]">Kategori</th>
                    <th class="text-center px-6 py-3.5 font-medium text-[var(--color-ink-muted)]">Total Peserta</th>
                    <th class="text-center px-6 py-3.5 font-medium text-[var(--color-ink-muted)]">Hadir</th>
                    <th class="text-left px-6 py-3.5 font-medium text-[var(--color-ink-muted)] w-64">Status Sertifikat</th>
                    <th class="text-right px-6 py-3.5 font-medium text-[var(--color-ink-muted)]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-border)]">
                @forelse($pelatihans as $p)
                    <tr class="hover:bg-[var(--color-surface-1)]/40 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[var(--color-ink)]">{{ $p->judul }}</div>
                            <div class="text-xs text-[var(--color-ink-muted)] mt-0.5">Tanggal: {{ $p->tanggal->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 text-[var(--color-ink-muted)]">{{ $p->kategori->nama_kategori }}</td>
                        <td class="px-6 py-4 text-center font-medium">{{ $p->total_peserta }}</td>
                        <td class="px-6 py-4 text-center text-[var(--color-success)] font-medium">{{ $p->total_hadir }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-between text-xs text-[var(--color-ink-muted)] mb-1">
                                <span>Terbit: <strong>{{ $p->total_sertifikat }}</strong> / {{ $p->total_hadir }} Hadir</span>
                                @if($p->total_hadir > 0)
                                    <span>{{ round(($p->total_sertifikat / $p->total_hadir) * 100) }}%</span>
                                @else
                                    <span>0%</span>
                                @endif
                            </div>
                            <div class="w-full bg-[var(--color-surface-2)] h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[var(--color-link)] h-full rounded-full transition-all duration-500" 
                                     style="width: {{ $p->total_hadir > 0 ? min(100, ($p->total_sertifikat / $p->total_hadir) * 100) : 0 }}%">
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.sertifikat.pelatihan.show', $p) }}" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[var(--color-surface-2)] hover:bg-[var(--color-border)] text-[var(--color-ink)] rounded-sm text-xs font-semibold hover:no-underline transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                Kelola Sertifikat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-[var(--color-ink-muted)]">
                            Belum ada kelas pelatihan yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $pelatihans->links() }}</div>
@endsection
