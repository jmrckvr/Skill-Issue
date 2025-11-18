<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search Bar -->
        <div class="mb-8">
            <form action="{{ route('jobs.search') }}" method="GET" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="keyword" placeholder="Job title, skills, company..." 
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('keyword', '') }}">
                    </div>
                    <div class="flex-1 relative">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <input type="text" name="location" placeholder="City or location" 
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('location', '') }}">
                    </div>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                        Search
                    </button>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-3">
                    <!-- Job Type Filter -->
                    <select name="job_type" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Job Types</option>
                        <option value="full-time" {{ request('job_type') === 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ request('job_type') === 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ request('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="freelance" {{ request('job_type') === 'freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>

                    <!-- Experience Level Filter -->
                    <select name="experience" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Levels</option>
                        <option value="entry" {{ request('experience') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                        <option value="mid" {{ request('experience') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                        <option value="senior" {{ request('experience') === 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="executive" {{ request('experience') === 'executive' ? 'selected' : '' }}>Executive</option>
                    </select>

                    <!-- Category Filter -->
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Clear Filters -->
                    @if(request()->anyFilled(['keyword', 'location', 'job_type', 'experience', 'category']))
                        <a href="{{ route('jobs.search') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-lg font-semibold transition text-sm">
                            Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Active Filters Display -->
        @if(request()->anyFilled(['keyword', 'location', 'job_type', 'experience', 'category']))
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm font-semibold text-blue-900 mb-2">Active Filters:</p>
                <div class="flex flex-wrap gap-2">
                    @if(request('keyword'))
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            Keyword: {{ request('keyword') }}
                        </span>
                    @endif
                    @if(request('location'))
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            Location: {{ request('location') }}
                        </span>
                    @endif
                    @if(request('job_type'))
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ ucfirst(request('job_type')) }} Job
                        </span>
                    @endif
                    @if(request('experience'))
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ ucfirst(request('experience')) }} Level
                        </span>
                    @endif
                    @if(request('category'))
                        @php
                            $selectedCategory = $categories->find(request('category'));
                        @endphp
                        @if($selectedCategory)
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                {{ $selectedCategory->name }}
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        <!-- Results -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                @if(request()->anyFilled(['keyword', 'location', 'job_type', 'experience', 'category']))
                    Search Results
                @else
                    All Jobs
                @endif
                <span class="text-gray-600 font-normal text-lg">({{ $jobs->total() }} {{ $jobs->total() === 1 ? 'job' : 'jobs' }})</span>
            </h1>
        </div>

        @if($jobs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($jobs as $job)
                    <x-cards.job-card :job="$job" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $jobs->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No jobs found</h2>
                <p class="text-gray-600 mb-6">Try adjusting your filters or search terms</p>
                <a href="{{ route('jobs.search') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                    View All Jobs
                </a>
            </div>
        @endif
    </div>

    @include('components.footer')
</body>
</html>
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
