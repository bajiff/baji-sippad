@extends('layouts.admin')

@section('title', 'Tambah Pelatihan')
@section('header', 'Tambah Pelatihan Baru')

@section('content')
<div class="max-w-2xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.pelatihan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Kategori *</label>
                    <select id="kategori_id" name="kategori_id" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                        <option value="">— Pilih —</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="kuota" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Kuota (kosongkan = tanpa batas)</label>
                    <input type="number" id="kuota" name="kuota" value="{{ old('kuota') }}" min="1"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('kuota') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Judul Pelatihan *</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                @error('judul') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="narasumber" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Narasumber *</label>
                    <input type="text" id="narasumber" name="narasumber" value="{{ old('narasumber') }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('narasumber') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="lokasi" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Lokasi *</label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('lokasi') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Tanggal *</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('tanggal') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="jam" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Jam *</label>
                    <input type="time" id="jam" name="jam" value="{{ old('jam') }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('jam') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="mb-4">
                <label for="persyaratan" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Persyaratan</label>
                <textarea id="persyaratan" name="persyaratan" rows="2" class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">{{ old('persyaratan') }}</textarea>
            </div>
            <div class="mb-4">
                <label for="thumbnail" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Foto Thumbnail (Wajib) *</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] bg-[var(--color-canvas)]">
                @error('thumbnail') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="sertifikat_enabled" value="1" {{ old('sertifikat_enabled', '1') ? 'checked' : '' }} class="rounded border-[var(--color-border)]">
                    Aktifkan Sertifikat
                </label>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)]">Simpan</button>
                <a href="{{ route('admin.pelatihan.index') }}" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
