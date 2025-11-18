@props(['name' => null, 'placeholder' => '', 'error' => null, 'rows' => 5, 'required' => false])

<div class="space-y-2">
    @if($name)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ ucfirst(str_replace('_', ' ', $name)) }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none ' . ($error ? 'border-red-500' : '')]) }}
    >{{ old($name) }}</textarea>

    @if($error)
        <p class="text-red-600 text-sm">{{ $error }}</p>
    @endif
</div>
