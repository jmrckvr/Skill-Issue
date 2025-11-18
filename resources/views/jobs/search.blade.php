<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('components.navbar')

    <div class="flex h-screen overflow-hidden">
        <!-- Left Sidebar -->
        <div class="w-96 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white overflow-y-auto hidden lg:block">
            <div class="p-8">
                <!-- Header -->
                <div class="mb-12">
                    <h1 class="text-white text-2xl font-bold mb-8">JobStreet</h1>
                </div>

                <!-- Search Form -->
                <form action="{{ route('jobs.search') }}" method="GET" class="space-y-6" id="searchForm">
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

                    @if(request()->anyFilled(['keyword', 'location', 'job_type', 'experience', 'category']))
                        <a href="{{ route('jobs.search') }}" class="block w-full text-center px-4 py-2 text-white border border-white border-opacity-30 rounded-lg hover:bg-white hover:bg-opacity-10 transition text-sm font-semibold">
                            Clear Filters
                        </a>
                    @endif
                </form>

                <!-- Quick Links -->
                <div class="mt-12 pt-8 border-t border-white border-opacity-20">
                    <p class="text-gray-300 text-xs uppercase tracking-wide font-semibold mb-4">All Jobs</p>
                    <div class="space-y-2">
                        <a href="{{ route('jobs.search', ['category' => 'Accounting']) }}" class="flex items-center text-gray-300 hover:text-white text-sm">
                            📊 Accounting
                        </a>
                        <a href="{{ route('jobs.search', ['category' => 'Philippines']) }}" class="flex items-center text-gray-300 hover:text-white text-sm">
                            🌏 Philippines
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle - Recommended Jobs -->
        <div class="flex-1 overflow-y-auto bg-gray-50">
            <div class="max-w-2xl mx-auto p-6 lg:p-8">
                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-gray-900 text-2xl font-bold mb-2">Recommended for you</h2>
                    <p class="text-gray-600 text-sm">🔍 Based on your profile and search history</p>
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
                                    @if($job->company->logo_path)
                                        <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" class="w-14 h-14 rounded object-cover ml-4">
                                    @else
                                        <div class="w-14 h-14 rounded bg-blue-100 flex items-center justify-center ml-4">
                                            <span class="text-blue-600 font-bold text-xs">{{ substr($job->company->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-wrap gap-3 my-4">
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <span>📍 {{ $job->location }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <span>💼 {{ ucfirst($job->job_type) }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <span>⏱️ {{ $job->published_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <span class="text-green-600 font-bold text-lg">{{ $job->getFormattedSalary() }}</span>
                                    <span class="text-gray-500 text-xs">High application volume</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-gray-600">No jobs found. Try adjusting your search.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Panel - Job Details -->
        <div class="hidden xl:flex xl:flex-col w-96 bg-white border-l border-gray-200 overflow-y-auto">
            <div id="jobDetailsPanel" class="p-6 h-full flex flex-col justify-center items-center text-center text-gray-500">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-base font-medium">Select a job to view details</p>
            </div>
        </div>
    </div>

    <script>
        // Initialize job card click handlers when DOM is ready
        function initJobCards() {
            document.querySelectorAll('.job-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    const jobId = this.getAttribute('data-job-id');
                    
                    // Highlight the selected job
                    document.querySelectorAll('.job-card').forEach(c => {
                        c.classList.remove('bg-blue-50', 'border-blue-600');
                        c.classList.add('border-transparent');
                    });
                    this.classList.add('bg-blue-50', 'border-blue-600');
                    this.classList.remove('border-transparent');

                    // Load job details
                    loadJobDetails(jobId);
                });
            });
        }

        // Run when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initJobCards);
        } else {
            initJobCards();
        }

        function loadJobDetails(jobId) {
            const panel = document.getElementById('jobDetailsPanel');
            
            // Show loading state
            panel.innerHTML = '<div class="flex flex-col items-center justify-center h-full"><svg class="animate-spin h-8 w-8 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg><p>Loading job details...</p></div>';
            
            // Fetch job details via AJAX
            fetch(`/api/jobs/${jobId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayJobDetails(data.job);
                    } else {
                        panel.innerHTML = '<div class="text-center text-red-600"><p>Error loading job details</p></div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    panel.innerHTML = '<div class="text-center text-red-600"><p>Error loading job details</p></div>';
                });
        }

        function displayJobDetails(job) {
            const panel = document.getElementById('jobDetailsPanel');
            const isSaved = job.is_saved || false;
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
            
            let html = `
                <div class="w-full h-full overflow-y-auto">
                    <div class="p-6 pb-8">
                        <!-- Company Logo & Title -->
                        <div class="mb-6">
                            ${job.company.logo_path ? `
                                <img src="/storage/${job.company.logo_path}" alt="${job.company.name}" class="w-16 h-16 rounded mb-4 object-cover">
                            ` : `
                                <div class="w-16 h-16 rounded bg-blue-100 flex items-center justify-center mb-4">
                                    <span class="text-blue-600 font-bold text-lg">${job.company.name.charAt(0)}</span>
                                </div>
                            `}
                            <h3 class="font-bold text-gray-900 text-lg">${job.title}</h3>
                            <p class="text-gray-600 text-sm mt-1">${job.company.name}</p>
                        </div>

                        <!-- Key Info -->
                        <div class="space-y-3 mb-6 pb-6 border-b border-gray-200 text-sm">
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-3">📍</span>
                                <div>
                                    <p class="text-gray-600 text-xs font-semibold">LOCATION</p>
                                    <p class="font-bold text-gray-900">${job.location}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-green-600 mr-3">💰</span>
                                <div>
                                    <p class="text-gray-600 text-xs font-semibold">SALARY</p>
                                    <p class="font-bold text-green-600">${job.formatted_salary}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-purple-600 mr-3">📋</span>
                                <div>
                                    <p class="text-gray-600 text-xs font-semibold">JOB TYPE</p>
                                    <p class="font-bold text-gray-900">${job.job_type.charAt(0).toUpperCase() + job.job_type.slice(1)}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-orange-600 mr-3">⏱️</span>
                                <div>
                                    <p class="text-gray-600 text-xs font-semibold">POSTED</p>
                                    <p class="font-bold text-gray-900">${job.posted_at}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2 mb-6">
                            ${isLoggedIn ? `
                                <button onclick="showApplyModal(${job.id})" style="background-color: #f53a6b; color: white; padding: 10px 12px; border-radius: 6px; font-weight: 700; width: 100%; border: none; cursor: pointer; font-size: 14px;">
                                    Quick apply
                                </button>
                                <form action="/jobs/${job.id}/save" method="POST" style="width: 100%; margin: 0;">
                                    @csrf
                                    <button type="submit" style="background-color: ${isSaved ? '#f59e0b' : '#f3f4f6'}; color: ${isSaved ? 'white' : '#1f2937'}; padding: 10px 12px; border-radius: 6px; font-weight: 700; width: 100%; border: none; cursor: pointer; font-size: 14px;">
                                        ${isSaved ? '★ Saved' : '☆ Save'}
                                    </button>
                                </form>
                            ` : `
                                <a href="/login" style="display: block; background-color: #2563eb; color: white; padding: 10px 12px; border-radius: 6px; font-weight: 700; width: 100%; border: none; cursor: pointer; text-align: center; text-decoration: none; font-size: 14px;">
                                    Login to Apply
                                </a>
                            `}
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-900 mb-2 text-sm">ABOUT THIS JOB</h4>
                            <p class="text-gray-700 text-sm leading-relaxed line-clamp-4">${job.description}</p>
                        </div>

                        <!-- Company Info -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-bold text-gray-900 mb-2 text-sm">COMPANY INFO</h4>
                            <p class="text-gray-600 text-xs mb-2">${job.company.industry || 'Industry not specified'}</p>
                            <p class="text-gray-600 text-xs">${job.company.employee_count ? job.company.employee_count + '+ employees' : 'Size not specified'}</p>
                        </div>

                        <!-- Match Section -->
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <h4 class="font-bold text-blue-900 mb-2 text-sm">HOW YOU MATCH</h4>
                            <p class="text-blue-700 text-xs">Matches based on your career history</p>
                        </div>

                        <!-- View Full Details Link -->
                        <div class="mt-6">
                            <a href="/jobs/${job.id}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                View full details →
                            </a>
                        </div>
                    </div>
                </div>
            `;
            
            panel.innerHTML = html;
        }

        function showApplyModal(jobId) {
            alert('Apply modal for job ' + jobId);
            // You can implement the apply modal here
        }
    </script>

    @include('components.footer')
</body>
</html>
