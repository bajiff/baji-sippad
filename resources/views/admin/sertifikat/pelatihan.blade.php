@extends('layouts.admin')

@section('title', 'Kelola Sertifikat')
@section('header', 'Kelola Sertifikat Pelatihan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.sertifikat.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-[var(--color-link)] hover:underline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Pelatihan
    </a>
</div>

<div class="card p-6 mb-6 bg-[var(--color-surface-1)]/30">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <span class="px-2.5 py-1 text-xs font-bold rounded-sm bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-900/40">{{ $pelatihan->kategori->nama_kategori }}</span>
            <h2 class="text-xl font-bold text-[var(--color-ink)] mt-2.5">{{ $pelatihan->judul }}</h2>
            <div class="flex flex-wrap gap-x-6 gap-y-1.5 text-xs text-[var(--color-ink-muted)] mt-2">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $pelatihan->tanggal->format('d M Y') }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ date('H:i', strtotime($pelatihan->jam)) }} WIB
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $pelatihan->lokasi }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Filters Panel -->
<div class="card p-6 mb-6">
    <form method="GET" action="{{ route('admin.sertifikat.pelatihan.show', $pelatihan) }}" class="flex flex-wrap items-end gap-4">
        <div class="w-full sm:w-auto">
            <label class="block text-xs font-semibold text-[var(--color-ink-muted)] uppercase tracking-wider mb-1.5">Filter Kehadiran</label>
            <select name="kehadiran" class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <option value="">Semua Status</option>
                <option value="hadir" {{ request('kehadiran') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="tidak_hadir" {{ request('kehadiran') === 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                <option value="belum_presensi" {{ request('kehadiran') === 'belum_presensi' ? 'selected' : '' }}>Belum Presensi</option>
            </select>
        </div>
        <div class="w-full sm:w-auto">
            <label class="block text-xs font-semibold text-[var(--color-ink-muted)] uppercase tracking-wider mb-1.5">Filter Sertifikat</label>
            <select name="sertifikat" class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <option value="">Semua Status</option>
                <option value="terbit" {{ request('sertifikat') === 'terbit' ? 'selected' : '' }}>Sudah Terbit</option>
                <option value="belum_terbit" {{ request('sertifikat') === 'belum_terbit' ? 'selected' : '' }}>Belum Terbit</option>
            </select>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <button type="submit" class="px-4 py-2 bg-[var(--color-surface-2)] text-[var(--color-ink)] hover:bg-[var(--color-border)] rounded text-sm font-semibold transition-colors">
                Terapkan Filter
            </button>
            @if(request()->hasAny(['kehadiran', 'sertifikat']))
                <a href="{{ route('admin.sertifikat.pelatihan.show', $pelatihan) }}" class="px-4 py-2 bg-[var(--color-canvas)] text-[var(--color-ink-muted)] border border-[var(--color-border)] hover:bg-[var(--color-surface-1)] rounded text-sm font-semibold hover:no-underline transition-colors flex items-center justify-center">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Bulk Actions & Table Card -->
<div x-data="{
    selected: [],
    selectAll: false,
    pendaftarans: {{ json_encode($pendaftarans->items() ? collect($pendaftarans->items())->pluck('id')->toArray() : []) }},
    toggleAll() {
        this.selectAll = !this.selectAll;
        this.selected = this.selectAll ? [...this.pendaftarans] : [];
    },
    submitForm(actionUrl, confirmMessage) {
        if (this.selected.length === 0) {
            alert('Silakan pilih minimal satu peserta.');
            return;
        }
        if (confirm(confirmMessage)) {
            const form = document.getElementById('bulk-form');
            form.action = actionUrl;
            
            form.querySelectorAll('input').forEach(el => { if (el.name === 'pendaftaran_ids[]') el.remove(); });
            
            // Append inputs dynamically
            this.selected.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'pendaftaran_ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            form.submit();
        }
    }
}" class="card overflow-hidden">
    
    <!-- Bulk Action Bar -->
    <div class="px-6 py-4 bg-[var(--color-surface-1)] border-b border-[var(--color-border)] flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <input type="checkbox" @click="toggleAll()" :checked="selectAll" class="w-4 h-4 rounded-sm border-[var(--color-border)] text-[var(--color-link)] focus:ring-[var(--color-link)] cursor-pointer">
            <span class="text-sm font-semibold text-[var(--color-ink)]">
                Pilih Semua Peserta Halaman Ini
            </span>
            <span class="text-xs px-2 py-0.5 bg-[var(--color-surface-2)] text-[var(--color-ink)] rounded-pill font-semibold" x-show="selected.length > 0">
                <span x-text="selected.length"></span> terpilih
            </span>
        </div>
        
        <div class="flex items-center gap-2">
            <button type="button" @click="submitForm('{{ route('admin.sertifikat.generate.bulk', $pelatihan) }}', 'Terbitkan sertifikat untuk peserta terpilih? (Ini juga akan otomatis menandai kehadiran mereka sebagai Hadir jika belum)')" 
                    class="px-4 py-2 bg-[var(--color-link)] hover:bg-[var(--color-link)]/90 text-white rounded-sm text-sm font-semibold shadow-sm transition-colors cursor-pointer"
                    :disabled="selected.length === 0"
                    :class="{ 'opacity-50 cursor-not-allowed': selected.length === 0 }">
                Generate Sertifikat
            </button>
            <button type="button" @click="submitForm('{{ route('admin.sertifikat.revoke.bulk', $pelatihan) }}', 'Batalkan sertifikat untuk peserta terpilih?')" 
                    class="px-4 py-2 bg-[var(--color-danger)] hover:bg-[var(--color-danger)]/90 text-white rounded-sm text-sm font-semibold shadow-sm transition-colors cursor-pointer"
                    :disabled="selected.length === 0"
                    :class="{ 'opacity-50 cursor-not-allowed': selected.length === 0 }">
                Batalkan Sertifikat
            </button>
        </div>
    </div>

    <!-- Real form for bulk action -->
    <form id="bulk-form" method="POST" action="" style="display: none;">
        @csrf
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-[var(--color-surface-1)]/50 border-b border-[var(--color-border)]">
                    <th class="px-6 py-3 w-12"></th>
                    <th class="text-left px-6 py-3 font-medium text-[var(--color-ink-muted)]">Peserta</th>
                    <th class="text-center px-6 py-3 font-medium text-[var(--color-ink-muted)]">Kehadiran</th>
                    <th class="text-left px-6 py-3 font-medium text-[var(--color-ink-muted)]">Status Sertifikat</th>
                    <th class="text-right px-6 py-3 font-medium text-[var(--color-ink-muted)]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--color-border)]">
                @forelse($pendaftarans as $p)
                    <tr class="hover:bg-[var(--color-surface-1)]/20 transition-colors">
                        <td class="px-6 py-4 text-center">
                            <input type="checkbox" value="{{ $p->id }}" x-model="selected" class="w-4 h-4 rounded-sm border-[var(--color-border)] text-[var(--color-link)] focus:ring-[var(--color-link)] cursor-pointer">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[var(--color-ink)]">{{ $p->user->name }}</div>
                            <div class="text-xs text-[var(--color-ink-muted)] mt-0.5">{{ $p->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->kehadiran)
                                @if($p->kehadiran->status_kehadiran === 'hadir')
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-pill bg-green-50 text-green-700 dark:bg-green-950/40 dark:text-green-400 border border-green-200 dark:border-green-900/40">Hadir</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-pill bg-red-50 text-red-700 dark:bg-red-950/40 dark:text-red-400 border border-red-200 dark:border-red-900/40">Tidak Hadir</span>
                                @endif
                            @else
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-pill bg-gray-50 text-gray-700 dark:bg-gray-800/40 dark:text-gray-400 border border-gray-200 dark:border-gray-700/40">Belum Presensi</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($p->kehadiran && $p->kehadiran->sertifikat)
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-[var(--color-link)]">Sudah Terbit</span>
                                    <span class="text-[10px] font-mono text-[var(--color-ink-muted)] mt-0.5">{{ $p->kehadiran->sertifikat->nomor_sertifikat }}</span>
                                </div>
                            @else
                                <span class="text-xs font-semibold text-[var(--color-ink-muted)]">Belum Terbit</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($p->kehadiran && $p->kehadiran->sertifikat)
                                <a href="{{ route('admin.sertifikat.download', $p->kehadiran->sertifikat) }}" 
                                   class="inline-flex items-center gap-1 text-xs font-bold text-[var(--color-link)] hover:underline hover:no-underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Unduh PDF
                                </a>
                            @else
                                <span class="text-xs text-[var(--color-ink-muted)]">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-[var(--color-ink-muted)]">
                            Tidak ada data peserta yang cocok dengan filter yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $pendaftarans->links() }}</div>
@endsection
