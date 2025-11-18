@props(['name', 'value' => null, 'type' => 'text', 'placeholder' => '', 'error' => null, 'required' => false])

<div class="space-y-2">
    @if($name)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ ucfirst(str_replace('_', ' ', $name)) }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition ' . ($error ? 'border-red-500' : '')]) }}
    />

    @if($error)
        <p class="text-red-600 text-sm">{{ $error }}</p>
    @endif
</div>
