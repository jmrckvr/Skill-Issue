<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Categories - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Job Categories</h1>
                <p class="text-gray-600 mt-2">Total Categories: {{ $categories->total() }}</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Add Category
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($categories as $category)
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-400">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-3xl mb-2">{{ $category->icon }}</p>
                            <h3 class="text-lg font-bold text-gray-900">{{ $category->name }}</h3>
                            <p class="text-gray-600 text-sm mt-1">Slug: {{ $category->slug }}</p>
                            <p class="text-gray-600 text-sm mt-2">
                                <strong>{{ $category->jobs_count }}</strong> {{ Str::plural('job', $category->jobs_count) }}
                            </p>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="block text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Edit
                            </a>
                            @if($category->jobs_count == 0)
                                <form action="{{ route('admin.categories.delete', $category) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete category?')" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div>
            {{ $categories->links() }}
        </div>
    </div>
</div>
</body>
</html>
