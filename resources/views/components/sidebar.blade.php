<aside class="fixed left-0 top-0 h-full w-64 bg-[var(--color-canvas)] border-r border-[var(--color-border)] z-40 flex flex-col">
    <div class="h-16 border-b border-[var(--color-border)] flex items-center px-6">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-[var(--color-ink)] hover:no-underline">
            SIPPAD
        </a>
        <span class="ml-2 text-xs px-2 py-0.5 rounded bg-[var(--color-primary)] text-[var(--color-on-primary)] font-medium">Admin</span>
    </div>

    <nav class="flex-1 py-4 overflow-y-auto">
        <ul class="space-y-1 px-3">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.kategori.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.kategori.*') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pelatihan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.pelatihan.*') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Pelatihan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pendaftaran.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Pendaftaran
                </a>
            </li>
            <li>
                <a href="{{ route('admin.kehadiran.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.kehadiran.*') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Kehadiran
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dokumentasi.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.dokumentasi.*') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Dokumentasi
                </a>
            </li>
            <li>
                <a href="{{ route('admin.sertifikat.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.sertifikat.*') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    Sertifikat
                </a>
            </li>
            <li>
                <a href="{{ route('admin.laporan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-[var(--color-surface-2)] text-[var(--color-ink)] font-medium' : 'text-[var(--color-ink-muted)] hover:bg-[var(--color-surface-1)] hover:text-[var(--color-ink)]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Laporan
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
