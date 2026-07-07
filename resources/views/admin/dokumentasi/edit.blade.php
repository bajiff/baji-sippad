@extends('layouts.admin')

@section('title', 'Edit Dokumentasi')
@section('header', 'Edit Dokumentasi Kegiatan')

@section('content')
<div class="max-w-xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.dokumentasi.update', $dokumentasi) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="pelatihan_id" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Pelatihan *</label>
                <select id="pelatihan_id" name="pelatihan_id" required class="w-full px-3 py-2 bg-[var(--color-canvas)] text-[var(--color-ink)] border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    <option value="" class="bg-[var(--color-canvas)] text-[var(--color-ink)]">— Pilih Pelatihan —</option>
                    @foreach($pelatihans as $p)
                        <option value="{{ $p->id }}" {{ (old('pelatihan_id', $dokumentasi->pelatihan_id) == $p->id) ? 'selected' : '' }} class="bg-[var(--color-canvas)] text-[var(--color-ink)]">{{ $p->judul }}</option>
                    @endforeach
                </select>
                @error('pelatihan_id') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--color-ink)] mb-2">Foto Saat Ini</label>
                <div class="w-48 h-48 bg-[var(--color-surface-1)] rounded overflow-hidden border border-[var(--color-border)] mb-2">
                    <img src="{{ Storage::url($dokumentasi->foto_kegiatan) }}" alt="Foto Dokumentasi" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="mb-6">
                <label for="foto" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Ganti Foto Kegiatan (Opsional)</label>
                <input type="file" id="foto" name="foto" accept="image/*"
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <p class="mt-1 text-xs text-[var(--color-ink-muted)]">Biarkan kosong jika tidak ingin mengganti foto. Maks 5MB. Format: JPG, PNG, WebP</p>
                @error('foto') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)]">Simpan Perubahan</button>
                <a href="{{ route('admin.dokumentasi.index') }}" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
