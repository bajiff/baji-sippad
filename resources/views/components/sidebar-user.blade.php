<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed left-0 top-0 h-full w-64 bg-[var(--color-canvas)] border-r border-[var(--color-border)] z-40 flex flex-col lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-16 border-b border-[var(--color-border)] flex items-center px-6 gap-2 justify-between">
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-1.5 font-bold hover:no-underline">
            <div class="w-6 h-6 bg-[var(--color-primary)] flex items-center justify-center text-white font-black text-sm tracking-tighter rounded-sm">A</div>
            <span class="text-lg tracking-tight text-[var(--color-ink)]">SIPPAD</span>
        </a>
        <div class="flex items-center gap-2">
            <span class="text-xs px-1.5 py-0.5 rounded bg-[var(--color-link)] text-white font-semibold uppercase tracking-wider">User</span>
            <!-- Close Button for Mobile -->
            <button @click="sidebarOpen = false" class="p-1 rounded hover:bg-[var(--color-surface-2)] text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] lg:hidden transition-colors" title="Tutup Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <nav class="flex-1 py-4 overflow-y-auto">
        <ul class="space-y-1 px-3">
            <li>
                <a href="{{ route('user.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('user.dashboard') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('user.pelatihan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('user.pelatihan.*') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Daftar Pelatihan
                </a>
            </li>
            <li>
                <a href="{{ route('user.riwayat') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('user.riwayat') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Riwayat Pelatihan
                </a>
            </li>
            <li>
                <a href="{{ route('user.profil') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('user.profil') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil Saya
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-4 border-t border-[var(--color-border)]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded text-sm text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-danger)] transition-colors w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
