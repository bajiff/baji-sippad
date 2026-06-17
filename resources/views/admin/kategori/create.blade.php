@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori Pelatihan')

@section('content')
<div class="max-w-xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf
            <div class="mb-4">
                <label for="nama_kategori" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Nama Kategori *</label>
                <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                @error('nama_kategori') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)]">Simpan</button>
                <a href="{{ route('admin.kategori.index') }}" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
