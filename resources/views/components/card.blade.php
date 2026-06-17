@props(['title' => null, 'subtitle' => null])

<div class="card p-6">
    @if($title || $subtitle)
        <div class="mb-4">
            @if($title)
                <h3 class="text-lg font-semibold text-[var(--color-ink)]">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="text-sm text-[var(--color-ink-muted)] mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
