<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search Results</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow sticky top-24">
                    <h3 class="font-bold text-lg mb-6">Filters</h3>

                    <form action="{{ route('jobs.search') }}" method="GET">
                        <!-- Keyword -->
                        <div class="mb-6">
                            <label class="font-semibold text-gray-900 block mb-2">Keyword</label>
                            <input type="text" name="keyword" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ $keyword }}">
                        </div>

                        <!-- Location -->
                        <div class="mb-6">
                            <label class="font-semibold text-gray-900 block mb-2">Location</label>
                            <input type="text" name="location" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ $location }}">
                        </div>

                        <!-- Category -->
                        <div class="mb-6">
                            <label class="font-semibold text-gray-900 block mb-2">Category</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Job Type -->
                        <div class="mb-6">
                            <label class="font-semibold text-gray-900 block mb-2">Job Type</label>
                            <select name="job_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">All Types</option>
                                <option value="full-time" {{ $jobType === 'full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part-time" {{ $jobType === 'part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="contract" {{ $jobType === 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="freelance" {{ $jobType === 'freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                        </div>

                        <!-- Experience Level -->
                        <div class="mb-6">
                            <label class="font-semibold text-gray-900 block mb-2">Experience</label>
                            <select name="experience" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">All Levels</option>
                                <option value="entry" {{ $experienceLevel === 'entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="mid" {{ $experienceLevel === 'mid' ? 'selected' : '' }}>Mid Level</option>
                                <option value="senior" {{ $experienceLevel === 'senior' ? 'selected' : '' }}>Senior</option>
                                <option value="executive" {{ $experienceLevel === 'executive' ? 'selected' : '' }}>Executive</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                            Apply Filters
                        </button>
                        <a href="{{ route('jobs.search') }}" class="w-full block text-center mt-2 text-gray-600 hover:text-gray-900 text-sm">
                            Clear All Filters
                        </a>
                    </form>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="lg:col-span-3">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Job Search Results</h1>
                    <p class="text-gray-600 mt-2">Found {{ $jobs->total() }} job(s)</p>
                </div>

                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h2>
                                    <p class="text-gray-600 mt-1">{{ $job->company->name }}</p>
                                </div>
                                @if($job->company->logo_path)
                                    <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}"
                                        class="w-16 h-16 rounded object-cover ml-4">
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($job->job_type) }}
                                </span>
                                <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($job->experience_level) }}
                                </span>
                                @if($job->category)
                                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $job->category->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">📍 Location</p>
                                    <p class="font-semibold">{{ $job->location }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">💰 Salary</p>
                                    <p class="font-semibold text-green-600">{{ $job->getFormattedSalary() }}</p>
                                </div>
                            </div>

                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $job->description }}</p>

                            <div class="flex justify-between items-center">
                                <p class="text-xs text-gray-500">{{ $job->published_at->diffForHumans() }}</p>
                                <a href="{{ route('jobs.show', $job) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-xl text-gray-600">No jobs found matching your criteria.</p>
                            <a href="{{ route('jobs.search') }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">
                                Clear filters and try again →
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($jobs->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $jobs->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('components.footer')
</body>
</html>
