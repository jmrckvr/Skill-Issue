@props(['text', 'type' => 'category', 'value' => null, 'clickable' => true, 'active' => false])

@php
    $colors = [
        'category' => 'bg-green-50 text-green-700 hover:bg-green-100',
        'job_type' => 'bg-blue-100 text-blue-700 hover:bg-blue-200',
        'experience' => 'bg-gray-100 text-gray-700 hover:bg-gray-200',
        'skill' => 'bg-purple-50 text-purple-700 hover:bg-purple-100',
    ];
    $color = $colors[$type] ?? 'bg-gray-100 text-gray-700 hover:bg-gray-200';
@endphp

@if($clickable && $value)
    <a
        href="{{ route('jobs.search', [$type => $value]) }}"
        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold {{ $color }} transition cursor-pointer {{ $active ? 'ring-2 ring-offset-2 ring-blue-500' : '' }}"
    >
        {{ $text }}
    </a>
@else
    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold {{ $color }}">
        {{ $text }}
    </span>
@endif
