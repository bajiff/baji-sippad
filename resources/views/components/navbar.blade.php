<nav class="h-16 border-b border-[var(--color-border)] bg-[var(--color-canvas)]/95 backdrop-blur-md sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-2 text-xl font-bold text-[var(--color-ink)] hover:no-underline group">
            <span class="w-5 h-5 bg-[var(--color-primary)] inline-flex items-center justify-center text-[10px] text-white font-bold rounded-sm shadow-sm transition-transform group-hover:scale-105 duration-200">S</span>
            <span class="tracking-tight">SIPPAD</span>
        </a>

        <div class="flex items-center gap-6">
            @auth
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                   class="text-sm font-medium text-[var(--color-ink)] hover:text-[var(--color-link)] hover:no-underline transition-colors duration-200">
                    Dashboard
                </a>
                <span class="text-sm text-[var(--color-ink-muted)]">|</span>
                <span class="text-sm font-medium text-[var(--color-ink-muted)]">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
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

