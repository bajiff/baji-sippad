<nav class="h-16 border-b border-[var(--color-border)] bg-[var(--color-canvas)] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-1.5 font-bold hover:no-underline">
            <div class="w-6 h-6 bg-[var(--color-primary)] flex items-center justify-center text-white font-black text-sm tracking-tighter rounded-sm">A</div>
            <span class="text-lg tracking-tight text-[var(--color-ink)]">SIPPAD</span>
        </a>

        <div class="flex items-center gap-6">
            <a href="{{ route('user.pelatihan.index') }}" class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] hover:no-underline transition-colors">Pelatihan</a>
            @auth
                <a href="{{ route('user.dashboard') }}" class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] hover:no-underline transition-colors">Dashboard</a>
                <a href="{{ route('user.riwayat') }}" class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] hover:no-underline transition-colors">Riwayat</a>
                <a href="{{ route('user.profil') }}" class="text-sm text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] hover:no-underline transition-colors">Profil</a>
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
