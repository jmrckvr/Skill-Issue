@props(['text' => 'Button', 'type' => 'submit', 'href' => null, 'variant' => 'primary', 'size' => 'md', 'disabled' => false])

@php
    $baseClass = 'font-semibold rounded-lg transition duration-200 transform active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $sizeClass = match($size) {
        'sm' => 'px-3 py-2 text-sm',
        'lg' => 'px-8 py-4 text-lg',
        default => 'px-6 py-3 text-base',
    };
    
    $variantClass = match($variant) {
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500 ' . ($disabled ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105'),
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-900 focus:ring-gray-400 ' . ($disabled ? 'opacity-50 cursor-not-allowed' : ''),
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500 ' . ($disabled ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105'),
        'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500 ' . ($disabled ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105'),
        default => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500 ' . ($disabled ? 'opacity-50 cursor-not-allowed' : 'hover:scale-105'),
    };
    
    $classes = "$baseClass $sizeClass $variantClass";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "inline-block $classes"]) }}>
        {{ $text }}
    </a>
@else
    <button type="{{ $type }}" @disabled($disabled) {{ $attributes->merge(['class' => $classes]) }}>
        {{ $text }}
    </button>
@endif
