@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<h2 class="text-xl font-semibold text-[var(--color-ink)] mb-6">Daftar Akun Baru</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Nama Lengkap *</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
               class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">
        @error('name')
            <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Email *</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required
               class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">
        @error('email')
            <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Password *</label>
        <input type="password" id="password" name="password" required
               class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">
        @error('password')
            <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Konfirmasi Password *</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required
               class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">
    </div>

    <div class="mb-4">
        <label for="no_hp" class="block text-sm font-medium text-[var(--color-ink)] mb-1">No. HP</label>
        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
               class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">
        @error('no_hp')
            <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="alamat" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Alamat</label>
        <textarea id="alamat" name="alamat" rows="2"
                  class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">{{ old('alamat') }}</textarea>
        @error('alamat')
            <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="tanggal_lahir" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Tanggal Lahir</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
               class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">
        @error('tanggal_lahir')
            <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="w-full py-2.5 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded font-medium text-sm hover:bg-[var(--color-primary-hover)] transition-colors">
        Daftar
    </button>
</form>

<p class="mt-6 text-center text-sm text-[var(--color-ink-muted)]">
    Sudah punya akun?
    <a href="{{ route('login') }}" class="text-[var(--color-link)] hover:underline">Masuk</a>
</p>
@endsection
