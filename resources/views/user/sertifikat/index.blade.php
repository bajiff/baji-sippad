@extends('layouts.user')

@section('title', 'Sertifikat Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-6">Sertifikat Saya</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($sertifikats as $s)
            <div class="card p-5 flex flex-col justify-between hover:shadow-lg transition-shadow duration-200">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="text-[10px] font-semibold text-[var(--color-primary)] bg-[var(--color-primary)]/10 px-2 py-0.5 rounded border border-[var(--color-primary)]/20">Sertifikat Kelulusan</span>
                        <span class="text-xs text-[var(--color-ink-muted)]">{{ $s->created_at->format('d/m/Y') }}</span>
                    </div>
                    <h3 class="font-bold text-[var(--color-ink)] text-base line-clamp-2 mb-2">
                        {{ $s->kehadiran->pendaftaran->pelatihan->judul }}
                    </h3>
                    <p class="text-xs text-[var(--color-ink-muted)] mb-4">
                        Nomor: {{ $s->nomor_sertifikat }}
                    </p>
                </div>
                <div class="pt-4 border-t border-[var(--color-border)] flex items-center justify-between mt-auto">
                    <span class="text-xs text-[var(--color-success)] font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Valid
                    </span>
                    <a href="{{ route('user.sertifikat.download', $s) }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-xs font-semibold hover:bg-[var(--color-primary-hover)] transition-colors hover:no-underline shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download PDF
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full card p-12 text-center text-[var(--color-ink-muted)]">
                <svg class="w-12 h-12 mx-auto text-[var(--color-ink-muted)] opacity-50 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <p class="font-medium">Belum ada sertifikat diterbitkan</p>
                <p class="text-xs mt-1">Sertifikat akan tersedia setelah Anda dinyatakan hadir oleh admin.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $sertifikats->links() }}</div>
</div>
@endsection
