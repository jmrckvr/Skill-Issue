@props(['type' => 'info', 'dismissible' => true])

@php
    $colors = [
        'info' => 'bg-blue-50 border-blue-200 text-blue-900',
        'success' => 'bg-green-50 border-green-200 text-green-900',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-900',
        'error' => 'bg-red-50 border-red-200 text-red-900',
    ];
    $color = $colors[$type] ?? $colors['info'];
@endphp

<div id="alert-{{ uniqid() }}" class="p-4 rounded-lg border {{ $color }} {{ $dismissible ? 'relative' : '' }}">
    <div class="flex gap-3">
        <div class="flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        @endif
    </div>
</div>
