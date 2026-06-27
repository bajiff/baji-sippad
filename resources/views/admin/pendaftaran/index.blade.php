@extends('layouts.admin')

@section('title', 'Verifikasi Pendaftaran')
@section('header', 'Verifikasi Pendaftaran')

@section('content')
<div x-data="{ openRejectModal: false, rejectUrl: '', rejectAlasan: 'Kriteria peserta belum sepenuhnya memenuhi syarat pelatihan ini.', customAlasan: '' }">
    @if($selectedPelatihan)
        <div class="card p-5 mb-6 border-l-4 {{ $selectedPelatihan->isFull() ? 'border-l-[var(--color-danger)] bg-red-500/5' : 'border-l-[var(--color-primary)]' }}">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-bold text-[var(--color-ink)]">{{ $selectedPelatihan->judul }}</h3>
                        @if($selectedPelatihan->isFull())
                            <span class="px-2 py-0.5 bg-[var(--color-danger)] text-white rounded text-[10px] font-bold tracking-wider uppercase">Kuota Penuh</span>
                        @endif
                    </div>
                    <p class="text-sm text-[var(--color-ink-muted)] mt-1">
                        Kapasitas Kuota: <span class="font-bold {{ $selectedPelatihan->isFull() ? 'text-[var(--color-danger)]' : 'text-[var(--color-success)]' }}">{{ $selectedPelatihan->approved_count }} / {{ $selectedPelatihan->kuota ?? '∞' }} Peserta Disetujui</span>
                    </p>
                    @if($selectedPelatihan->isFull())
                        <p class="text-xs font-medium text-[var(--color-danger)] mt-1.5">
                            ⚠️ Kuota pelatihan telah habis! Anda tidak dapat menyetujui peserta baru pada pelatihan ini kecuali kuota diperbarui.
                        </p>
                    @endif
                </div>
                <div>
                    <a href="{{ route('admin.pelatihan.edit', $selectedPelatihan) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-[var(--color-surface-2)] border border-[var(--color-border)] rounded text-xs font-medium text-[var(--color-ink)] hover:bg-[var(--color-border)] transition-colors">
                        ⚙️ Update Kuota
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="card p-4 mb-6">
        <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[240px]">
                <label class="block text-xs font-semibold text-[var(--color-ink)] mb-1 uppercase tracking-wider">Filter Pelatihan (Lihat Kuota)</label>
                <select name="pelatihan_id" onchange="this.form.submit()" class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    <option value="">Semua Pelatihan</option>
                    @foreach($pelatihans as $pel)
                        <option value="{{ $pel->id }}" {{ request('pelatihan_id') == $pel->id ? 'selected' : '' }}>
                            {{ $pel->judul }} — Terisi {{ $pel->approved_count }}/{{ $pel->kuota ?? '∞' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[var(--color-ink)] mb-1 uppercase tracking-wider">Status</label>
                <select name="status" onchange="this.form.submit()" class="px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            @if(request()->anyFilled(['pelatihan_id', 'status']))
                <a href="{{ route('admin.pendaftaran.index') }}" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]">Reset</a>
            @endif
        </form>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[var(--color-surface-1)]">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Nama</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Email</th>
                    <th class="text-left px-4 py-3 font-medium text-[var(--color-ink-muted)]">Pelatihan & Kuota</th>
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
                        <td class="px-4 py-3">
                            <div class="font-medium text-[var(--color-ink)]">{{ $p->pelatihan->judul }}</div>
                            <div class="text-xs text-[var(--color-ink-muted)] mt-0.5">
                                Kuota: <span class="font-semibold {{ $p->pelatihan->isFull() ? 'text-[var(--color-danger)]' : 'text-[var(--color-success)]' }}">{{ $p->pelatihan->approved_count }}/{{ $p->pelatihan->kuota ?? '∞' }}</span>
                            </div>
                        </td>
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
                                @if($p->pelatihan->isFull())
                                    <div class="flex items-center justify-end gap-2">
                                        <span class="px-2.5 py-1 bg-[var(--color-surface-2)] text-[var(--color-danger)] rounded text-xs font-bold border border-[var(--color-danger)]/30 cursor-not-allowed" title="Tidak dapat menyetujui karena kuota telah penuh ({{ $p->pelatihan->approved_count }}/{{ $p->pelatihan->kuota }})">Kuota Penuh</span>
                                        <button type="button" @click="openRejectModal = true; rejectUrl = '{{ route('admin.pendaftaran.tolak', $p) }}'" class="px-3 py-1 bg-[var(--color-danger)] text-white rounded text-xs font-medium hover:bg-red-700">Tolak</button>
                                    </div>
                                @else
                                    <div class="flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.pendaftaran.setujui', $p) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-[var(--color-success)] text-white rounded text-xs font-medium hover:bg-green-700">Setujui</button>
                                        </form>
                                        <button type="button" @click="openRejectModal = true; rejectUrl = '{{ route('admin.pendaftaran.tolak', $p) }}'" class="px-3 py-1 bg-[var(--color-danger)] text-white rounded text-xs font-medium hover:bg-red-700">Tolak</button>
                                    </div>
                                @endif
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
