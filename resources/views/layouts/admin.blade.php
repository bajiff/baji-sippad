<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — SIPPAD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex bg-[var(--color-surface-1)]">
    @include('components.sidebar')

    <div class="flex-1 flex flex-col ml-64">
        <header class="h-16 border-b border-[var(--color-border)] bg-[var(--color-canvas)] flex items-center px-6 sticky top-0 z-30">
            <h1 class="text-lg font-semibold text-[var(--color-ink)]">@yield('header', 'Dashboard')</h1>
            <div class="ml-auto flex items-center gap-4">
                <span class="text-sm text-[var(--color-ink-muted)]">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-danger)] transition-colors">Logout</button>
                </form>
            </div>
        </header>

        <main class="flex-1 p-6">
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
        </main>
    </div>

    @stack('scripts')
</body>
</html>
