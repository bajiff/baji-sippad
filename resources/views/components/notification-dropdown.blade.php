@php
    $unreadNotifications = auth()->user()->unreadNotifications;
    $unreadCount = $unreadNotifications->count();
@endphp

<div x-data="{ open: false }" class="relative">
    <!-- Bell Icon Button -->
    <button @click="open = !open" 
            class="relative p-2 rounded hover:bg-[var(--color-surface-2)] text-[var(--color-ink-muted)] hover:text-[var(--color-ink)] transition-colors flex items-center justify-center focus:outline-none" 
            title="Notifikasi"
            aria-haspopup="true"
            :aria-expanded="open.toString()">
        
        <!-- Bell SVG -->
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>

        <!-- Red Badge Counter -->
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-[var(--color-danger)] rounded-full transform translate-x-1 -translate-y-1">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Menu Panel -->
    <div x-show="open" 
         @click.outside="open = false"
         x-transition:enter="transition ease-out duration-130"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 sm:w-96 rounded-[var(--radius-lg)] border border-[var(--color-border)] bg-[var(--color-canvas)] shadow-[var(--shadow-elevated)] z-30 overflow-hidden origin-top-right focus:outline-none"
         style="display: none;"
         role="menu"
         aria-orientation="vertical">
        
        <!-- Dropdown Header -->
        <div class="px-4 py-3 bg-[var(--color-surface-1)] border-b border-[var(--color-border)] flex items-center justify-between">
            <span class="text-sm font-semibold text-[var(--color-ink)]">Notifikasi</span>
            
            @if($unreadCount > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-[var(--color-link)] hover:underline focus:outline-none font-medium">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        <!-- Dropdown List Body -->
        <div class="max-h-80 overflow-y-auto divide-y divide-[var(--color-border)]">
            @forelse($unreadNotifications as $notification)
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="block m-0">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 hover:bg-[var(--color-surface-2)] transition-colors flex flex-col gap-1 focus:bg-[var(--color-surface-2)] focus:outline-none cursor-pointer">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-[var(--color-link)]">
                                {{ $notification->data['status'] === 'disetujui' ? 'Disetujui' : 'Ditolak' }}
                            </span>
                            <span class="text-[10px] text-[var(--color-ink-muted)]">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-xs text-[var(--color-ink)] leading-snug">
                            {{ $notification->data['message'] }}
                        </p>
                    </button>
                </form>
            @empty
                <div class="px-4 py-8 text-center flex flex-col items-center justify-center gap-2">
                    <svg class="w-8 h-8 text-[var(--color-ink-muted)] opacity-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-[var(--color-ink-muted)]">Tidak ada notifikasi baru</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
