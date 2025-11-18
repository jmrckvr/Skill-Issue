<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    @include('components.navbar')

    <div class="flex h-screen overflow-hidden bg-gray-100">
        <!-- Left Sidebar - Search & Filters -->
        <div class="hidden md:flex md:flex-col w-80 bg-white border-r border-gray-200 overflow-y-auto">
            <form action="{{ route('jobs.search') }}" method="GET" class="p-6 space-y-6">
                <!-- What Section -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">What</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="keyword" placeholder="Enter keywords" 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-sm"
                            value="{{ request('keyword', '') }}">
                    </div>
                </div>

                <!-- Where Section -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Where</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <input type="text" name="location" placeholder="City or location" 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-sm"
                            value="{{ request('location', '') }}">
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Category</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Job Type Filter -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Job Type</label>
                    <select name="job_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Types</option>
                        <option value="full-time" {{ request('job_type') === 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ request('job_type') === 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ request('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="freelance" {{ request('job_type') === 'freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                </div>

                <!-- Experience Level Filter -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Experience</label>
                    <select name="experience" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Levels</option>
                        <option value="entry" {{ request('experience') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                        <option value="mid" {{ request('experience') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                        <option value="senior" {{ request('experience') === 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="executive" {{ request('experience') === 'executive' ? 'selected' : '' }}>Executive</option>
                    </select>
                </div>

                <!-- Search Button -->
                <button type="submit" style="background-color: #2563eb; color: white; padding: 10px 16px; border-radius: 6px; font-weight: 600; width: 100%; border: none; cursor: pointer; transition: background-color 0.3s;">
                    Search Jobs
                </button>

                <!-- Clear Filters -->
                @if(request()->anyFilled(['keyword', 'location', 'job_type', 'experience', 'category']))
                    <a href="{{ route('jobs.search') }}" class="block w-full text-center px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm font-semibold">
                        Clear Filters
                    </a>
                @endif
            </form>
        </div>

        <!-- Middle - Job Listings -->
        <div class="flex-1 overflow-y-auto md:w-96">
            <div class="bg-white border-r border-gray-200">
                <!-- Header with job count -->
                <div class="sticky top-0 bg-white border-b border-gray-200 p-4 sm:p-6">
                    <h2 class="text-lg font-bold text-gray-900">
                        @if(request()->anyFilled(['keyword', 'location', 'job_type', 'experience', 'category']))
                            Search Results
                        @else
                            All Jobs
                        @endif
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $jobs->total() }} {{ $jobs->total() === 1 ? 'job' : 'jobs' }} found</p>
                </div>

                <!-- Job List -->
                <div class="divide-y divide-gray-200">
                    @if($jobs->count() > 0)
                        @foreach($jobs as $job)
                            <a href="{{ route('jobs.show', $job) }}" class="block p-4 sm:p-6 hover:bg-blue-50 transition border-l-4 border-transparent hover:border-blue-600 cursor-pointer" data-job-id="{{ $job->id }}">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-base">{{ $job->title }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $job->company->name }}</p>
                                    </div>
                                    @if($job->company->logo_path)
                                        <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" class="w-12 h-12 rounded object-cover ml-3">
                                    @else
                                        <div class="w-12 h-12 rounded bg-blue-100 flex items-center justify-center ml-3">
                                            <span class="text-blue-600 font-bold text-sm">{{ substr($job->company->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mb-2">📍 {{ $job->location }}</p>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="inline-block text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">{{ ucfirst($job->job_type) }}</span>
                                    <span class="inline-block text-xs px-2 py-1 bg-gray-100 text-gray-800 rounded">{{ ucfirst($job->experience_level) }}</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="text-sm font-semibold text-green-600">{{ $job->getFormattedSalary() }}</span>
                                    <span class="text-xs text-gray-500">{{ $job->published_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-8 text-center text-gray-600">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <p class="text-sm">No jobs found. Try adjusting your search.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Panel - Job Details (Sticky) -->
        <div class="hidden lg:flex lg:flex-col flex-1 bg-gray-50 overflow-y-auto">
            <div id="jobDetailsPanel" class="p-8 h-full flex flex-col justify-center items-center text-center text-gray-500">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-base">Select a job to view details</p>
            </div>
        </div>
    </div>

    <script>
        // Load job details when clicking on a job
        document.querySelectorAll('[data-job-id]').forEach(jobElement => {
            jobElement.addEventListener('click', function(e) {
                e.preventDefault();
                const jobId = this.getAttribute('data-job-id');
                const jobUrl = this.getAttribute('href');
                
                // On mobile, just navigate
                if (window.innerWidth < 1024) {
                    window.location.href = jobUrl;
                    return;
                }
                
                // Load job details via AJAX for desktop
                const detailsPanel = document.getElementById('jobDetailsPanel');
                
                // For now, just navigate - you can add AJAX loading later
                window.location.href = jobUrl;
            });
        });
    </script>

    @include('components.footer')
</body>
</html>
