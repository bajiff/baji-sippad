@extends('layouts.admin')

@section('title', 'Verifikasi Pendaftaran')
@section('header', 'Verifikasi Pendaftaran')

@section('content')
<div x-data="{ openRejectModal: false, rejectUrl: '', rejectAlasan: 'Kriteria peserta belum sepenuhnya memenuhi syarat pelatihan ini.', customAlasan: '' }">
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
                                @if($p->alasan_penolakan)
                                    <p class="text-[10px] text-red-500 mt-1 max-w-[150px] line-clamp-2" title="{{ $p->alasan_penolakan }}">Alasan: {{ $p->alasan_penolakan }}</p>
                                @endif
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($p->status === 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.pendaftaran.setujui', $p) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="px-3 py-1 bg-[var(--color-success)] text-white rounded text-xs font-medium hover:bg-green-700">Setujui</button>
                                    </form>
                                    <button type="button" @click="openRejectModal = true; rejectUrl = '{{ route('admin.pendaftaran.tolak', $p) }}'" class="px-3 py-1 bg-[var(--color-danger)] text-white rounded text-xs font-medium hover:bg-red-700">Tolak</button>
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

    <!-- Modal Penolakan -->
    <div x-show="openRejectModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div @click.away="openRejectModal = false" class="bg-[var(--color-canvas)] rounded-lg shadow-xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-[var(--color-ink)] mb-4">Tolak Pendaftaran</h3>
            <p class="text-sm text-[var(--color-ink-muted)] mb-4">Silakan pilih atau tulis alasan penolakan yang akan dikirimkan ke peserta agar mereka memahami kekurangannya.</p>
            
            <form :action="rejectUrl" method="POST">
                @csrf @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-[var(--color-ink)] mb-3">Pilih Saran Alasan:</label>
                    <div class="space-y-2.5">
                        <label class="flex items-start gap-2 cursor-pointer group">
                            <input type="radio" x-model="rejectAlasan" value="Kriteria peserta belum sepenuhnya memenuhi syarat pelatihan ini. Jangan menyerah, coba lagi pada pelatihan lain!" class="mt-0.5 accent-[var(--color-danger)]">
                            <span class="text-sm text-[var(--color-ink)] group-hover:text-[var(--color-ink-muted)] transition-colors">Kriteria tidak sesuai persyaratan.</span>
                        </label>
                        <label class="flex items-start gap-2 cursor-pointer group">
                            <input type="radio" x-model="rejectAlasan" value="Mohon maaf, prioritas saat ini difokuskan pada perwakilan dusun/wilayah lain yang belum mendapat kuota." class="mt-0.5 accent-[var(--color-danger)]">
                            <span class="text-sm text-[var(--color-ink)] group-hover:text-[var(--color-ink-muted)] transition-colors">Prioritas untuk perwakilan wilayah/dusun lain.</span>
                        </label>
                        <label class="flex items-start gap-2 cursor-pointer group">
                            <input type="radio" x-model="rejectAlasan" value="Profil data diri Anda kurang lengkap. Harap lengkapi profil Anda terlebih dahulu sebelum mendaftar ulang." class="mt-0.5 accent-[var(--color-danger)]">
                            <span class="text-sm text-[var(--color-ink)] group-hover:text-[var(--color-ink-muted)] transition-colors">Profil/data diri kurang lengkap.</span>
                        </label>
                        <label class="flex items-start gap-2 cursor-pointer group">
                            <input type="radio" x-model="rejectAlasan" value="custom" class="mt-0.5 accent-[var(--color-danger)]">
                            <span class="text-sm text-[var(--color-ink)] group-hover:text-[var(--color-ink-muted)] transition-colors font-semibold">Tulis Alasan Manual</span>
                        </label>
                    </div>
                </div>

                <div x-show="rejectAlasan === 'custom'" x-collapse>
                    <div class="mb-4">
                        <textarea x-model="customAlasan" rows="3" class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:border-[var(--color-danger)] focus:ring-1 focus:ring-[var(--color-danger)]" placeholder="Masukkan alasan penolakan secara spesifik..."></textarea>
                    </div>
                </div>

                <!-- Hidden Input untuk mengirim alasan final -->
                <input type="hidden" name="alasan_penolakan" :value="rejectAlasan === 'custom' ? customAlasan : rejectAlasan">

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[var(--color-border)]">
                    <button type="button" @click="openRejectModal = false" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)] transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[var(--color-danger)] text-white rounded text-sm font-medium hover:bg-red-700 transition-colors">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
