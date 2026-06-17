<nav class="h-16 border-b border-[var(--color-border)] bg-[var(--color-canvas)] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">
        <a href="{{ route('landing') }}" class="text-xl font-bold text-[var(--color-ink)] hover:no-underline">
            SIPPAD
        </a>

        <div class="flex items-center gap-6">
            @auth
                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                   class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] hover:no-underline transition-colors">
                    Dashboard
                </a>
                <span class="text-sm text-[var(--color-ink-muted)]">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-danger)] transition-colors">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] hover:no-underline transition-colors">Login</a>
                <a href="{{ route('register') }}" class="text-sm px-4 py-2 rounded bg-[var(--color-primary)] text-[var(--color-on-primary)] hover:bg-[var(--color-primary-hover)] hover:no-underline transition-colors">Register</a>
            @endauth
        </div>
    </div>
</nav>
