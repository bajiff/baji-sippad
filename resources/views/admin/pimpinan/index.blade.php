@extends('layouts.admin')

@section('title', 'Data Pimpinan Desa')
@section('header', 'Data Pimpinan Desa')

@section('content')
<div class="max-w-2xl mx-auto py-4">
    @if(session('success'))
        <div class="mb-4 p-4 rounded-md bg-[var(--color-surface-1)] border border-[var(--color-primary)] text-[var(--color-ink)] text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-6">
        <div class="mb-6 pb-4 border-b border-[var(--color-border)]">
            <h3 class="text-base font-semibold text-[var(--color-ink)]">Pengaturan Pimpinan & Desa</h3>
            <p class="text-xs text-[var(--color-ink-muted)] mt-1">
                Data ini digunakan sebagai acuan resmi penandatanganan dan lokasi pada penerbitan Sertifikat Pelatihan serta Laporan PDF SIPPAD.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.pimpinan.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="nama_desa" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Nama Desa *</label>
                <input type="text" id="nama_desa" name="nama_desa" value="{{ old('nama_desa', $pimpinan->nama_desa) }}" required
                       placeholder="Contoh: Suranenggala Kidul atau Sari Mukti"
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <p class="text-[11px] text-[var(--color-ink-muted)] mt-1.5">Nama desa yang akan tercetak pada bagian tempat tanggal terbit di sertifikat dan laporan.</p>
                @error('nama_desa') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="nama_kepala_desa" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Nama Kepala Desa / Pimpinan *</label>
                <input type="text" id="nama_kepala_desa" name="nama_kepala_desa" value="{{ old('nama_kepala_desa', $pimpinan->nama_kepala_desa) }}" required
                       placeholder="Contoh: Pemerintah Desa Suranenggala Kidul atau H. Budi Santoso, S.Sos."
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <p class="text-[11px] text-[var(--color-ink-muted)] mt-1.5">Nama atau jabatan resmi pihak penandatangan pada bagian bawah sertifikat dan laporan.</p>
                @error('nama_kepala_desa') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-[var(--color-border)] flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)] transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
