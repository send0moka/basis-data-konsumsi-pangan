@props(['href' => null, 'variant' => null])

@php
$baseClasses = 'inline-flex items-center gap-2';
$variantClasses = match($variant) {
    'ghost' => 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white',
    default => ''
};
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses]) }}>
        {{ $slot }}
    </button>
@endif
