@props(['id' => 'modal', 'title' => ''])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50" data-modal-backdrop></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-[var(--color-canvas)] rounded-lg shadow-[var(--shadow-elevated)] w-full max-w-lg" role="document">
            @if($title)
                <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--color-border)]">
                    <h3 class="text-lg font-semibold text-[var(--color-ink)]">{{ $title }}</h3>
                    <button type="button" class="text-[var(--color-ink-muted)] hover:text-[var(--color-ink)]" data-modal-close aria-label="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            <div class="px-6 py-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
