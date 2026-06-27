@extends('layouts.admin')

@section('title', 'Edit Akun')
@section('header', 'Edit Akun')

@section('content')
<div class="max-w-2xl">
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.accounts.update', $account) }}">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $account->name) }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('name') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Alamat Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $account->email) }}" required
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('email') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('password') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="role" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Role Akun *</label>
                    @if($account->id === auth()->id())
                        <input type="hidden" name="role" value="{{ $account->role }}">
                        <select disabled class="w-full px-3 py-2 border border-[var(--color-border)] bg-[var(--color-surface-1)] rounded text-sm text-[var(--color-ink-muted)]">
                            <option selected>{{ ucfirst($account->role) }} (Akun Sendiri)</option>
                        </select>
                        <p class="text-[10px] text-[var(--color-ink-muted)] mt-1">Anda tidak dapat mengubah role akun Anda sendiri.</p>
                    @elseif(auth()->user()->isSuperAdmin())
                        <select id="role" name="role" required class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                            <option value="user" {{ old('role', $account->role) == 'user' ? 'selected' : '' }}>User (Peserta)</option>
                            <option value="admin" {{ old('role', $account->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    @else
                        <input type="hidden" name="role" value="{{ $account->role }}">
                        <select disabled class="w-full px-3 py-2 border border-[var(--color-border)] bg-[var(--color-surface-1)] rounded text-sm text-[var(--color-ink-muted)]">
                            <option selected>{{ ucfirst($account->role) }}</option>
                        </select>
                        <p class="text-[10px] text-[var(--color-ink-muted)] mt-1">Hanya Superadmin yang dapat mengubah role akun.</p>
                    @endif
                    @error('role') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-[var(--color-ink)] mb-1">No. Handphone</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $account->no_hp) }}" placeholder="Contoh: 081234567890"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('no_hp') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $account->tanggal_lahir?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">
                    @error('tanggal_lahir') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center">
                    @if($account->isSuperAdmin())
                        <div class="mt-5">
                            <label class="flex items-center gap-2 text-sm text-[var(--color-ink-muted)]">
                                <input type="checkbox" checked disabled class="rounded border-[var(--color-border)] bg-[var(--color-surface-1)]">
                                <span class="font-medium">Superadmin (Status Permanen)</span>
                            </label>
                            <p class="text-[10px] text-[var(--color-ink-muted)] mt-1">Status Superadmin bersifat permanen dan tidak dapat dibuat/diubah melalui antarmuka ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <label for="alamat" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Alamat Rumah</label>
                <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap..." 
                          class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)]">{{ old('alamat', $account->alamat) }}</textarea>
                @error('alamat') <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded text-sm font-medium hover:bg-[var(--color-primary-hover)] transition-colors">Simpan Perubahan</button>
                <a href="{{ route('admin.accounts.index') }}" class="px-4 py-2 border border-[var(--color-border)] rounded text-sm text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
