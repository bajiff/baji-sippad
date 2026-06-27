@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('header', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto py-4">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.profil.update') }}">
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
                <p class="text-[10px] text-[var(--color-ink-muted)] mt-1">Alamat email tidak dapat diubah langsung demi alasan keamanan.</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--color-ink)] mb-1">Role Akun</label>
                <input type="text" value="{{ ucfirst($user->role) }} {{ $user->isSuperAdmin() ? '(Superadmin)' : '' }}" disabled
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm bg-[var(--color-surface-1)] text-[var(--color-ink-muted)] font-medium">
            </div>

            <div class="mb-4">
                <label for="no_hp" class="block text-sm font-medium text-[var(--color-ink)] mb-1">No. HP</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 081234567890"
                       class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                @error('no_hp') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Alamat</label>
                <textarea id="alamat" name="alamat" rows="2" placeholder="Alamat lengkap..." class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">{{ old('alamat', $user->alamat) }}</textarea>
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
                    <input type="password" id="current_password" name="current_password" placeholder="Masukkan password saat ini untuk verifikasi"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('current_password') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="block text-sm text-[var(--color-ink-muted)] mb-1">Password Baru</label>
                    <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('password') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm text-[var(--color-ink-muted)] mb-1">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru"
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
