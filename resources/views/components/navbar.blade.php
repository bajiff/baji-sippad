<nav class="h-16 border-b border-[var(--color-border)] bg-[var(--color-canvas)]/95 backdrop-blur-md sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 text-xl font-bold text-[var(--color-ink)] hover:no-underline group">
            <span class="w-5 h-5 bg-[var(--color-primary)] inline-flex items-center justify-center text-[10px] text-white font-bold rounded-sm shadow-sm transition-transform group-hover:scale-105 duration-200">S</span>
            <span class="tracking-tight">SIPPAD</span>
        </a>

        <div class="flex items-center gap-6">
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

            @auth
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                   class="text-sm font-medium text-[var(--color-ink)] hover:text-[var(--color-link)] hover:no-underline transition-colors duration-200">
                    Dashboard
                </a>
                <span class="text-sm text-[var(--color-ink-muted)]">|</span>
                <span class="text-sm font-medium text-[var(--color-ink-muted)]">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem?');">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-[var(--color-ink-muted)] hover:text-[var(--color-danger)] hover:underline cursor-pointer transition-colors duration-200">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium !text-ink-muted hover:!text-link hover:no-underline transition-colors duration-200">
                    Login
                </a>
                <a href="{{ route('register') }}" class="text-sm font-medium px-4 py-2 rounded-sm bg-primary !text-white hover:bg-primary-hover hover:no-underline transition-all duration-200 shadow-sm hover:shadow-md">
                    Register
                </a>

            @endauth
        </div>
    </div>
</nav>

