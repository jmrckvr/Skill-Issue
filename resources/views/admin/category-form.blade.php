<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Form - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">
                    @if(isset($category))
                        Edit Category
                    @else
                        Create Category
                    @endif
                </h1>
            </div>

            <form action="@if(isset($category)){{ route('admin.categories.update', $category) }}@else{{ route('admin.categories.store') }}@endif" method="POST" class="p-6 space-y-6">
                @csrf
                @if(isset($category))
                    @method('PATCH')
                @endif

                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="e.g., Information Technology"
                           required>
                    @error('name')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700">Icon (Emoji) <span class="text-red-500">*</span></label>
                    <div class="mt-1 flex gap-2">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon ?? '') }}" 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-2xl text-center"
                               placeholder="💻"
                               maxlength="2"
                               required>
                        <div class="text-4xl mt-1">{{ old('icon', $category->icon ?? '📁') }}</div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Enter an emoji to represent this category</p>
                    @error('icon')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Common Emojis Quick Select -->
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Quick Select:</p>
                    <div class="flex gap-2 flex-wrap">
                        @foreach(['💻', '⚕️', '💰', '📱', '🎨', '⚙️', '📚', '🏥', '📦', '🛍️'] as $emoji)
                            <button type="button" onclick="document.getElementById('icon').value = '{{ $emoji }}'; document.querySelector('.emoji-preview').textContent = '{{ $emoji }}';" 
                                    class="text-2xl p-2 border border-gray-300 rounded hover:bg-gray-100">
                                {{ $emoji }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.categories') }}" class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        @if(isset($category))
                            Update Category
                        @else
                            Create Category
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
