@extends('layouts.user')

@section('title', 'Riwayat Pelatihan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-6">Riwayat Pelatihan</h1>

    <div class="space-y-4">
        @forelse($riwayat as $r)
            <div class="card p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-[var(--color-ink)]">{{ $r->pelatihan->judul }}</h3>
                        <p class="text-sm text-[var(--color-ink-muted)] mt-1">{{ $r->pelatihan->kategori->nama_kategori }} &middot; {{ $r->pelatihan->tanggal->format('d M Y') }}</p>
                    </div>
                    @if($r->kehadiran && $r->kehadiran->status_kehadiran === 'hadir')
                        <x-badge variant="success">Hadir</x-badge>
                    @else
                        @if(in_array($r->pelatihan->status, ['publish', 'selesai']) && $r->pelatihan->presensi_by === 'peserta')
                            <div class="flex items-center gap-2">
                                @if($r->kehadiran && $r->kehadiran->status_kehadiran === 'tidak_hadir')
                                    <x-badge variant="danger">Tidak Hadir</x-badge>
                                @endif
                                <form method="POST" action="{{ route('user.pendaftaran.presensi', $r) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-white bg-[var(--color-primary)] rounded text-xs font-medium hover:bg-[var(--color-primary-hover)] transition-colors">
                                        Presensi Mandiri
                                    </button>
                                </form>
                            </div>
                        @else
                            @if($r->kehadiran && $r->kehadiran->status_kehadiran === 'tidak_hadir')
                                <x-badge variant="danger">Tidak Hadir</x-badge>
                            @else
                                <x-badge variant="default">—</x-badge>
                            @endif
                        @endif
                    @endif
                </div>
                @if($r->kehadiran && $r->kehadiran->sertifikat)
                    <div class="mt-3 pt-3 border-t border-[var(--color-border)]">
                        <p class="text-xs text-[var(--color-ink-muted)]">Sertifikat: {{ $r->kehadiran->sertifikat->nomor_sertifikat }}</p>
                        <a href="{{ route('user.sertifikat.download', $r->kehadiran->sertifikat) }}" class="text-[var(--color-link)] text-sm hover:underline">Download Sertifikat</a>
                    </div>
                @endif

                @if($r->pelatihan->dokumentasi && $r->pelatihan->dokumentasi->count() > 0)
                    <div class="mt-4 pt-4 border-t border-[var(--color-border)]">
                        <h4 class="text-sm font-semibold text-[var(--color-ink)] mb-3">Galeri Kegiatan</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                            @foreach($r->pelatihan->dokumentasi as $d)
                                <div class="aspect-square rounded overflow-hidden border border-[var(--color-border)]">
                                    <img src="{{ Storage::url($d->foto_kegiatan) }}" alt="Dokumentasi Kegiatan" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="card p-12 text-center text-[var(--color-ink-muted)]">Belum ada riwayat pelatihan</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $riwayat->links() }}</div>
</div>
@endsection
