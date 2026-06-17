@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<h2 class="text-xl font-semibold text-[var(--color-ink)] mb-6">Masuk ke Akun Anda</h2>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">
        @error('email')
            <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-[var(--color-ink)] mb-1">Password</label>
        <input type="password" id="password" name="password" required
               class="w-full px-3 py-2 border border-[var(--color-border)] rounded text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-link)] focus:border-transparent">
        @error('password')
            <p class="mt-1 text-xs text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center mb-6">
        <input type="checkbox" id="remember" name="remember" class="mr-2 rounded border-[var(--color-border)]">
        <label for="remember" class="text-sm text-[var(--color-ink-muted)]">Ingat saya</label>
    </div>

    <button type="submit" class="w-full py-2.5 bg-[var(--color-primary)] text-[var(--color-on-primary)] rounded font-medium text-sm hover:bg-[var(--color-primary-hover)] transition-colors">
        Masuk
    </button>
</form>

<p class="mt-6 text-center text-sm text-[var(--color-ink-muted)]">
    Belum punya akun?
    <a href="{{ route('register') }}" class="text-[var(--color-link)] hover:underline">Daftar sekarang</a>
</p>
@endsection
