<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — SIPPAD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('theme-dark');
        } else {
            document.documentElement.classList.remove('theme-dark');
        }
    </script>
</head>
<body x-data="{ sidebarOpen: false }" class="min-h-screen flex bg-[var(--color-surface-1)] text-[var(--color-ink)] bg-grid-pattern overflow-x-hidden">
    <!-- Backdrop for mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak x-transition></div>

    @include('components.sidebar')

    <div class="flex-1 flex flex-col lg:ml-64 min-w-0">
        <header class="h-16 border-b border-[var(--color-border)] bg-[var(--color-canvas)] flex items-center px-4 lg:px-6 sticky top-0 z-20">
            <!-- Hamburger Menu Button -->
            <button @click="sidebarOpen = true" class="mr-3 p-2 rounded hover:bg-[var(--color-surface-2)] text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] lg:hidden transition-colors" title="Buka Sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <h1 class="text-lg font-semibold text-[var(--color-ink)]">@yield('header', 'Dashboard')</h1>
            <div class="ml-auto flex items-center gap-6">
                <!-- Theme Toggle Button -->
                <div x-data="{ 
                    dark: localStorage.getItem('theme') === 'dark',
                    toggle() {
                        this.dark = !this.dark;
                        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                        if (this.dark) {
                            document.documentElement.classList.add('theme-dark');
                        } else {
                            document.documentElement.classList.remove('theme-dark');
                        }
                    }
                }">
                    <button @click="toggle()" class="p-2 rounded hover:bg-[var(--color-surface-2)] text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] transition-colors flex items-center justify-center" title="Ubah Tema">
                        <!-- Sun Icon (show when dark is true) -->
                        <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        <!-- Moon Icon (show when dark is false) -->
                        <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                </div>

                @include('components.notification-dropdown')

                <span class="text-sm text-[var(--color-ink-muted)] font-medium">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem?');">
                    @csrf
                    <button type="submit" class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-danger)] transition-colors cursor-pointer">Logout</button>
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
