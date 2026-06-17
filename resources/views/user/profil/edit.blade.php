@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-[var(--color-ink)] mb-6">Profil Saya</h1>

    <div class="card p-6">
        <form method="POST" action="{{ route('user.profil.update') }}">
            @csrf @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Nama Lengkap *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                @error('name') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Email</label>
                <input type="email" value="{{ $user->email }}" disabled
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm bg-[var(--color-surface-1)] text-[var(--color-ink-muted)]">
            </div>

            <div class="mb-4">
                <label for="no_hp" class="block text-sm font-medium text-[var(--color-ink)] mb-1">No. HP</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                @error('no_hp') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Alamat</label>
                <textarea id="alamat" name="alamat" rows="2" class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="tanggal_lahir" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                @error('tanggal_lahir') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="border-t border-[var(--color-border)] pt-4 mt-6 mb-4">
                <p class="text-sm font-medium text-[var(--color-ink)] mb-3">Ubah Password (opsional)</p>
                <div class="mb-3">
                    <label for="current_password" class="block text-sm text-[var(--color-ink-muted)] mb-1">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('current_password') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="block text-sm text-[var(--color-ink-muted)] mb-1">Password Baru</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('password') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm text-[var(--color-ink-muted)] mb-1">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                </div>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)] transition-colors">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
