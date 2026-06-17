@extends('layouts.admin')

@section('title', 'Upload Dokumentasi')
@section('header', 'Upload Dokumentasi')

@section('content')
<div class="max-w-xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.dokumentasi.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="pelatihan_id" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Pelatihan *</label>
                <select id="pelatihan_id" name="pelatihan_id" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    <option value="">— Pilih Pelatihan —</option>
                    @foreach($pelatihans as $p)
                        <option value="{{ $p->id }}" {{ old('pelatihan_id') == $p->id ? 'selected' : '' }}>{{ $p->judul }}</option>
                    @endforeach
                </select>
                @error('pelatihan_id') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label for="foto" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Foto Kegiatan *</label>
                <input type="file" id="foto" name="foto" accept="image/*" required
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                <p class="mt-1 text-xs text-[var(--color-ink-muted)]">Maks 5MB. Format: JPG, PNG, WebP</p>
                @error('foto') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)]">Upload</button>
                <a href="{{ route('admin.dokumentasi.index') }}" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
