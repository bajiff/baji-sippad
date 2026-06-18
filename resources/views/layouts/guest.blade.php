<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPPAD') — Sistem Pendaftaran Pelatihan Anak Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-[var(--color-surface-1)]">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-2 mb-2">
                <div class="w-8 h-8 bg-[var(--color-primary)] flex items-center justify-center text-white font-black text-lg tracking-tighter rounded-sm">A</div>
                <span class="text-3xl font-bold tracking-tight text-[var(--color-ink)]">SIPPAD</span>
            </div>
            <p class="text-sm text-[var(--color-ink-muted)] mt-1">Sistem Pendaftaran Pelatihan Anak Desa</p>
        </div>

        <div class="card p-8">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded bg-green-50 border border-green-200 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded bg-red-50 border border-red-200 text-red-800 text-sm">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>

        <p class="text-center text-xs text-[var(--color-ink-muted)] mt-6">
            &copy; {{ date('Y') }} SIPPAD
        </p>
    </div>

    @stack('scripts')
</body>
</html>
