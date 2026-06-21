@extends('layouts.admin')

@section('title', 'Edit Pelatihan')
@section('header', 'Edit Pelatihan')

@section('content')
<div class="max-w-2xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.pelatihan.update', $pelatihan) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Kategori *</label>
                    <select id="kategori_id" name="kategori_id" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id', $pelatihan->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="kuota" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Kuota</label>
                    <input type="number" id="kuota" name="kuota" value="{{ old('kuota', $pelatihan->kuota) }}" min="1"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                </div>
            </div>
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Judul Pelatihan *</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $pelatihan->judul) }}" required
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                @error('judul') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">{{ old('deskripsi', $pelatihan->deskripsi) }}</textarea>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="narasumber" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Narasumber *</label>
                    <input type="text" id="narasumber" name="narasumber" value="{{ old('narasumber', $pelatihan->narasumber) }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                </div>
                <div>
                    <label for="lokasi" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Lokasi *</label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $pelatihan->lokasi) }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Tanggal *</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $pelatihan->tanggal->format('Y-m-d')) }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                </div>
                <div>
                    <label for="jam" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Jam *</label>
                    <input type="time" id="jam" name="jam" value="{{ old('jam', $pelatihan->jam) }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                </div>
            </div>
            <div class="mb-4">
                <label for="persyaratan" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Persyaratan</label>
                <textarea id="persyaratan" name="persyaratan" rows="2" class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">{{ old('persyaratan', $pelatihan->persyaratan) }}</textarea>
            </div>
            <div class="mb-4">
                <label for="thumbnail" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Foto Thumbnail (Biarkan kosong jika tidak ingin mengubah)</label>
                @if($pelatihan->thumbnail)
                    <div class="mb-2">
                        <img src="{{ Storage::url($pelatihan->thumbnail) }}" alt="Thumbnail saat ini" class="w-32 h-20 object-cover rounded border border-[var(--color-border)]">
                    </div>
                @endif
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] bg-[var(--color-canvas)]">
                @error('thumbnail') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="sertifikat_enabled" value="1" {{ old('sertifikat_enabled', $pelatihan->sertifikat_enabled) ? 'checked' : '' }} class="rounded border-[var(--color-border)]">
                    Aktifkan Sertifikat
                </label>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)]">Perbarui</button>
                <a href="{{ route('admin.pelatihan.index') }}" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
