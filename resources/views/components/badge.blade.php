@props(['variant' => 'default'])

@php
    $classes = match($variant) {
        'success' => 'bg-green-50 text-green-800 border-green-200',
        'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'danger' => 'bg-red-50 text-red-800 border-red-200',
        'info' => 'bg-blue-50 text-blue-800 border-blue-200',
        default => 'bg-gray-50 text-gray-800 border-gray-200',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $classes }}">
    {{ $slot }}
</span>
