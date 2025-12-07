<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('components.navbar')

    <div class="flex h-screen overflow-hidden" style="height: calc(100vh - 64px);">
        <!-- LEFT SIDEBAR - Search Filters -->
        <div class="w-96 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white overflow-y-auto hidden lg:block shadow-xl">
            <div class="p-8">
                <!-- Header -->
                <div class="mb-12">
                    <h1 class="text-white text-2xl font-bold mb-8">JobStreet</h1>
                </div>

                <!-- Search Form -->
                <form action="{{ route('jobs.search') }}" method="GET" class="space-y-6" id="searchForm">
                    <!-- Hidden Company Filter -->
                    @if(request('company'))
                        <input type="hidden" name="company" value="{{ request('company') }}">
                    @endif

                    <!-- What Section -->
                    <div>
                        <label class="block text-white text-lg font-semibold mb-4">What</label>
                        <input type="text" name="keyword" placeholder="Enter keywords" 
                            class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-gray-300 border border-white border-opacity-30 focus:outline-none focus:border-white text-sm"
                            value="{{ request('keyword', '') }}">
                    </div>

                    <!-- Where Section -->
                    <div>
                        <label class="block text-white text-lg font-semibold mb-4">Where</label>
                        <input type="text" name="location" placeholder="City or location" 
                            class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-gray-300 border border-white border-opacity-30 focus:outline-none focus:border-white text-sm"
                            value="{{ request('location', '') }}">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-white text-sm font-semibold mb-3 uppercase tracking-wide">Category</label>
                        <select name="category" class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 text-white border border-white border-opacity-30 focus:outline-none focus:border-white text-sm">
                            <option value="" style="color: #000;">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" style="color: #000;" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Job Type Filter -->
                    <div>
                        <label class="block text-white text-sm font-semibold mb-3 uppercase tracking-wide">Job Type</label>
                        <select name="job_type" class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 text-white border border-white border-opacity-30 focus:outline-none focus:border-white text-sm">
                            <option value="" style="color: #000;">All Types</option>
                            <option value="full-time" style="color: #000;" {{ request('job_type') === 'full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="part-time" style="color: #000;" {{ request('job_type') === 'part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="contract" style="color: #000;" {{ request('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="freelance" style="color: #000;" {{ request('job_type') === 'freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>

                    <!-- Experience Level Filter -->
                    <div>
                        <label class="block text-white text-sm font-semibold mb-3 uppercase tracking-wide">Experience</label>
                        <select name="experience" class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 text-white border border-white border-opacity-30 focus:outline-none focus:border-white text-sm">
                            <option value="" style="color: #000;">All Levels</option>
                            <option value="entry" style="color: #000;" {{ request('experience') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                            <option value="mid" style="color: #000;" {{ request('experience') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                            <option value="senior" style="color: #000;" {{ request('experience') === 'senior' ? 'selected' : '' }}>Senior</option>
                            <option value="executive" style="color: #000;" {{ request('experience') === 'executive' ? 'selected' : '' }}>Executive</option>
                        </select>
                    </div>

                    <button type="submit" style="background-color: #2563eb; color: white; padding: 12px 16px; border-radius: 6px; font-weight: 600; width: 100%; border: none; cursor: pointer; transition: background-color 0.3s; margin-top: 12px;">
                        Search
                    </button>

                    @if(request()->anyFilled(['keyword', 'location', 'job_type', 'experience', 'category', 'company']))
                        <a href="{{ route('jobs.search') }}" class="block w-full text-center px-4 py-2 text-white border border-white border-opacity-30 rounded-lg hover:bg-white hover:bg-opacity-10 transition text-sm font-semibold">
                            Clear Filters
                        </a>
                    @endif
                </form>

                <!-- Quick Links -->
                <div class="mt-12 pt-8 border-t border-white border-opacity-20">
                    <p class="text-gray-300 text-xs uppercase tracking-wide font-semibold mb-4">Quick Links</p>
                    <div class="space-y-2">
                        <a href="{{ route('jobs.search', ['job_type' => 'full-time']) }}" class="flex items-center text-gray-300 hover:text-white text-sm transition">
                            💼 Full-time
                        </a>
                        <a href="{{ route('jobs.search', ['job_type' => 'part-time']) }}" class="flex items-center text-gray-300 hover:text-white text-sm transition">
                            🕐 Part-time
                        </a>
                        <a href="{{ route('jobs.search', ['experience' => 'entry']) }}" class="flex items-center text-gray-300 hover:text-white text-sm transition">
                            🎓 Entry Level
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CENTER - Job List -->
        <div class="flex-1 overflow-y-auto bg-gray-50 border-r border-gray-200">
            <div class="max-w-2xl mx-auto p-6 lg:p-8">
                <!-- Header -->
                <div class="mb-8">
                    @php
                        $headerText = 'Jobs for you';
                        if (request('company')) {
                            $companyId = request('company');
                            $company = \App\Models\Company::find($companyId);
                            if ($company) {
                                $headerText = 'Jobs at ' . $company->name;
                            }
                        }
                    @endphp
                    
                    <h2 class="text-gray-900 text-2xl font-bold mb-2">{{ $headerText }}</h2>
                    <p class="text-gray-600 text-sm">
                        @if($jobs->count() > 0)
                            {{ $jobs->count() }} position{{ $jobs->count() !== 1 ? 's' : '' }} available
                        @else
                            No jobs found
                        @endif
                    </p>
                </div>

                @if($jobs->count() > 0)
                    <div class="space-y-4" id="jobsList">
                        @foreach($jobs as $job)
                            <a href="javascript:void(0)" class="block bg-white rounded-lg shadow hover:shadow-lg transition p-6 border-l-4 border-transparent hover:border-blue-600 group job-card cursor-pointer" data-job-id="{{ $job->id }}">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 text-lg group-hover:text-blue-600 transition">{{ $job->title }}</h3>
                                        <p class="text-gray-600 text-sm mt-1">{{ $job->company->name }}</p>
                                    </div>
                                    @php
                                        $logoUrl = null;
                                        if ($job->logo) {
                                            $logoUrl = str_starts_with($job->logo, 'http') ? $job->logo : asset('storage/' . $job->logo);
                                        } elseif ($job->company->logo_path) {
                                            $logoUrl = str_starts_with($job->company->logo_path, 'http') ? $job->company->logo_path : asset('storage/' . $job->company->logo_path);
                                        }
                                    @endphp
                                    @if($logoUrl)
                                        <img src="{{ $logoUrl }}" alt="{{ $job->company->name }}" class="w-14 h-14 rounded object-cover ml-4" loading="lazy" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2256%22 height=%2256%22 viewBox=%220 0 56 56%22%3E%3Crect width=%2256%22 height=%2256%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                                    @else
                                        <div class="w-14 h-14 rounded bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center ml-4">
                                            <span class="text-blue-600 font-bold text-sm">{{ substr($job->company->name, 0, 2) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-wrap gap-3 my-4">
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <span>📍 {{ $job->location }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <span>💼 {{ ucfirst(str_replace('-', ' ', $job->job_type)) }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <span>⏱️ {{ $job->published_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <span class="text-green-600 font-bold text-lg">{{ $job->getFormattedSalary() }}</span>
                                    <span class="text-gray-500 text-xs">{{ $job->application_count }} applications</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-gray-600 font-medium">No jobs found. Try adjusting your search.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script>
        console.log('Search page loaded, initializing job cards...');
        
        // Initialize job card click handlers when DOM is ready
        function initJobCards() {
            console.log('initJobCards called');
            const cards = document.querySelectorAll('.job-card');
            console.log(`Found ${cards.length} job cards`);
            
            if (cards.length === 0) {
                console.warn('No job cards found! Checking if sidebar exists:', !!document.getElementById('jobDetailSidebar'));
            }
            
            cards.forEach((card, index) => {
                console.log(`Attaching click handler to job card ${index + 1}`);
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    const jobId = this.getAttribute('data-job-id');
                    console.log('Job card clicked! Job ID:', jobId);
                    
                    // Highlight the selected job
                    document.querySelectorAll('.job-card').forEach(c => {
                        c.classList.remove('bg-blue-50', 'border-blue-600');
                        c.classList.add('border-transparent');
                    });
                    this.classList.add('bg-blue-50', 'border-blue-600');
                    this.classList.remove('border-transparent');

                    // Open the sidebar
                    console.log('Calling openJobDetailSidebar with jobId:', jobId);
                    if (typeof openJobDetailSidebar === 'function') {
                        openJobDetailSidebar(jobId);
                    } else {
                        console.error('openJobDetailSidebar function not found!');
                    }
                });
            });
        }

        // Run when DOM is ready
        if (document.readyState === 'loading') {
            console.log('DOM still loading, waiting for DOMContentLoaded');
            document.addEventListener('DOMContentLoaded', initJobCards);
        } else {
            console.log('DOM already loaded, initializing immediately');
            initJobCards();
        }
    </script>

    <!-- Include the job detail sidebar component -->
    @include('components.job-detail-sidebar')

    @include('components.footer')
</body>
</html>
