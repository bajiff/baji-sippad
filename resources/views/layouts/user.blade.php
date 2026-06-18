<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPPAD') — Sistem Pendaftaran Pelatihan Anak Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="theme-dark min-h-screen flex flex-col bg-[var(--color-canvas)] text-[var(--color-ink)] bg-grid-pattern">
    @include('components.navbar-user')

    <main class="flex-1">
        @if(session('success'))
            <div class="max-w-7xl mx-auto mt-4 px-4">
                <div class="px-4 py-3 rounded bg-green-50 border border-green-200 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto mt-4 px-4">
                <div class="px-4 py-3 rounded bg-red-50 border border-red-200 text-red-800 text-sm">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-[var(--color-border)] bg-[var(--color-surface-1)] py-6 mt-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-[var(--color-ink-muted)]">
            &copy; {{ date('Y') }} SIPPAD — Sistem Pendaftaran Pelatihan Anak Desa
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
