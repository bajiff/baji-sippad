@extends('layouts.user')

@section('title', $pelatihan->judul)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('user.pelatihan.index') }}" class="text-[var(--color-link)] text-sm hover:underline mb-4 inline-block">← Kembali ke Daftar Pelatihan</a>

    <div class="card p-6">
        <div class="flex items-center gap-2 mb-3">
            <x-badge>{{ $pelatihan->kategori->nama_kategori }}</x-badge>
            @if($pelatihan->isFull())
                <x-badge variant="danger">Kuota Penuh</x-badge>
            @endif
        </div>

        <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-4">{{ $pelatihan->judul }}</h1>

        <div class="grid md:grid-cols-2 gap-4 mb-6 text-sm">
            <div>
                <p class="text-[var(--color-ink-muted)]">Narasumber</p>
                <p class="font-medium text-[var(--color-ink)]">{{ $pelatihan->narasumber }}</p>
            </div>
            <div>
                <p class="text-[var(--color-ink-muted)]">Lokasi</p>
                <p class="font-medium text-[var(--color-ink)]">{{ $pelatihan->lokasi }}</p>
            </div>
            <div>
                <p class="text-[var(--color-ink-muted)]">Tanggal & Jam</p>
                <p class="font-medium text-[var(--color-ink)]">{{ $pelatihan->tanggal->format('d M Y') }} &middot; {{ $pelatihan->jam }}</p>
            </div>
            <div>
                <p class="text-[var(--color-ink-muted)]">Kuota</p>
                <p class="font-medium text-[var(--color-ink)]">{{ $pelatihan->kuota ?? 'Tanpa batas' }} ({{ $pelatihan->approved_count }} terdaftar)</p>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="font-semibold text-[var(--color-ink)] mb-2">Deskripsi</h2>
            <p class="text-sm text-[var(--color-ink-muted)] leading-relaxed">{{ $pelatihan->deskripsi }}</p>
        </div>

        @if($pelatihan->persyaratan)
            <div class="mb-6">
                <h2 class="font-semibold text-[var(--color-ink)] mb-2">Persyaratan</h2>
                <p class="text-sm text-[var(--color-ink-muted)] leading-relaxed">{{ $pelatihan->persyaratan }}</p>
            </div>
        @endif

        <div class="border-t border-[var(--color-border)] pt-4">
            @if($userPendaftaran)
                @if($userPendaftaran->status === 'pending')
                    <div class="flex items-center gap-3">
                        <x-badge variant="warning">Pendaftaran Anda: Menunggu Verifikasi</x-badge>
                    </div>
                @elseif($userPendaftaran->status === 'disetujui')
                    <div class="flex items-center gap-3">
                        <x-badge variant="success">Pendaftaran Anda: Disetujui</x-badge>
                        @if((!$userPendaftaran->kehadiran || $userPendaftaran->kehadiran->status_kehadiran !== 'hadir') && in_array($pelatihan->status, ['publish', 'selesai']) && $pelatihan->presensi_by === 'peserta')
                            <div class="flex items-center gap-2">
                                @if($userPendaftaran->kehadiran && $userPendaftaran->kehadiran->status_kehadiran === 'tidak_hadir')
                                    <x-badge variant="danger">Kehadiran: Tidak Hadir</x-badge>
                                @endif
                                <form method="POST" action="{{ route('user.pendaftaran.presensi', $userPendaftaran) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-[var(--color-primary)] text-white rounded text-xs font-medium hover:bg-[var(--color-primary-hover)] transition-colors">
                                        Presensi Mandiri
                                    </button>
                                </form>
                            </div>
                        @elseif($userPendaftaran->kehadiran)
                            @if($userPendaftaran->kehadiran->status_kehadiran === 'hadir')
                                <x-badge variant="success">Kehadiran: Hadir</x-badge>
                            @else
                                <x-badge variant="danger">Kehadiran: Tidak Hadir</x-badge>
                            @endif
                        @endif
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <x-badge variant="danger">Pendaftaran Anda: Ditolak</x-badge>
                    </div>
                @endif
            @else
                <form method="POST" action="{{ route('user.pendaftaran.store', $pelatihan) }}">
                    @csrf
                    <button type="submit" {{ $pelatihan->isFull() || $pelatihan->status === 'closed' ? 'disabled' : '' }}
                            class="px-6 py-2.5 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded font-medium text-sm hover:bg-[var(--color-primary-hover)] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ $pelatihan->isFull() || $pelatihan->status === 'closed' ? 'Sudah Penuh' : 'Daftar Pelatihan Ini' }}
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
