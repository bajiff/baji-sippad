<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPPAD') — Sistem Pendaftaran Pelatihan Anak Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('theme-dark');
        } else {
            document.documentElement.classList.remove('theme-dark');
        }
    </script>
</head>
<body class="min-h-screen flex flex-col">
    @include('components.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @if(!Request::routeIs('landing'))
    <footer class="border-t border-[var(--color-border)] bg-[var(--color-surface-1)] py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-[var(--color-ink-muted)]">
            &copy; {{ date('Y') }} SIPPAD — Sistem Pendaftaran Pelatihan Anak Desa
        </div>
    </footer>
    @endif


    @stack('scripts')
</body>
</html>
