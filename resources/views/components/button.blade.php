@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
    $base = 'inline-flex items-center justify-center font-medium rounded transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-link)] disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = match($variant) {
        'primary' => 'bg-[var(--color-primary)] text-[var(--color-on-primary)] hover:bg-[var(--color-primary-hover)]',
        'secondary' => 'bg-[var(--color-surface-2)] text-[var(--color-ink)] hover:bg-[var(--color-border)]',
        'outline' => 'border border-[var(--color-border)] text-[var(--color-ink)] hover:bg-[var(--color-surface-1)]',
        'danger' => 'bg-[var(--color-danger)] text-[var(--color-on-primary)] hover:bg-red-700',
        'success' => 'bg-[var(--color-success)] text-white hover:bg-green-700',
        'link' => 'text-[var(--color-link)] hover:underline',
    };

    $sizes = match($size) {
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "$base $variants $sizes"]) }}>
    {{ $slot }}
</button>
