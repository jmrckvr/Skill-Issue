<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobStreet - Find Your Perfect Job</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <!-- Navigation -->
    @include('components.navbar')

    <!-- Hero Section with Search -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Find Your Dream Job</h1>
                <p class="text-lg text-blue-100">Search from thousands of job openings in Philippines</p>
            </div>

            <!-- Search Bar -->
            <form action="{{ route('jobs.search') }}" method="GET" class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" name="keyword" placeholder="Job title or keyword" 
                        class="px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ request('keyword', '') }}">
                    <input type="text" name="location" placeholder="City or location" 
                        class="px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ request('location', '') }}">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 px-6 py-3 rounded-lg font-semibold transition">
                        Search Jobs
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalJobs }}</p>
                    <p class="text-gray-600 mt-2">Active Job Listings</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-blue-600">{{ $totalCompanies }}</p>
                    <p class="text-gray-600 mt-2">Hiring Companies</p>
                </div>
                <div>
                    <p class="text-4xl font-bold text-blue-600">50k+</p>
                    <p class="text-gray-600 mt-2">Job Seekers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Browse by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('jobs.search', ['category' => $category->id]) }}" 
                        class="p-6 bg-white border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-lg transition text-center">
                        <div class="text-3xl mb-3">{{ $category->icon ?? '💼' }}</div>
                        <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                        <p class="text-sm text-gray-500 mt-2">{{ $category->job_count }} jobs</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Latest Jobs Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Latest Job Openings</h2>
                <a href="{{ route('jobs.search') }}" class="text-blue-600 hover:text-blue-800 font-semibold">View all →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($latestJobs as $job)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $job->title }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $job->company->name }}</p>
                            </div>
                            @if($job->company->logo_path)
                                <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" 
                                    class="w-12 h-12 rounded object-cover">
                            @else
                                <div class="w-12 h-12 bg-gray-300 rounded flex items-center justify-center">
                                    <span class="text-xs text-gray-600">Logo</span>
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold mr-2">
                                    {{ ucfirst($job->job_type) }}
                                </span>
                                <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($job->experience_level) }}
                                </span>
                            </p>
                            <p class="text-sm text-gray-600">📍 {{ $job->location }}</p>
                        </div>

                        <div class="mb-4">
                            @if(!$job->hide_salary && ($job->salary_min || $job->salary_max))
                                <p class="font-semibold text-green-600">{{ $job->getFormattedSalary() }}</p>
                            @else
                                <p class="text-sm text-gray-500">Salary not disclosed</p>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $job->description }}</p>

                        <div class="flex justify-between items-center">
                            <p class="text-xs text-gray-500">{{ $job->published_at->diffForHumans() }}</p>
                            <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                View →
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 col-span-full text-center py-8">No jobs available yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')
</body>
</html>
