<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skill Issue - Find Your Perfect Job</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <!-- Navigation -->
    @include('components.navbar')

    <!-- Hero Section with Search -->
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 text-white py-20 md:py-32 overflow-hidden">
        <!-- Decorative pink circles -->
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-pink-500 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute top-20 -left-20 w-40 h-40 bg-pink-600 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute -bottom-10 right-10 w-48 h-48 bg-blue-500 rounded-full opacity-10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
            <!-- Search Bar -->
            <form action="{{ route('jobs.search') }}" method="GET" class="max-w-5xl mx-auto">
                <div class="space-y-6">

                    <!-- Input Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <!-- What Input -->
                        <div class="md:col-span-1">
                            <label class="text-white text-lg font-semibold mb-2 block">What</label>
                            <input type="text" name="keyword" placeholder="Enter keywords" 
                                class="w-full px-5 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 font-medium"
                                value="{{ request('keyword', '') }}">
                        </div>

                        <!-- Classification Dropdown -->
                        <div class="md:col-span-1">
                            <select name="category" class="w-full px-5 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-pink-500 font-medium">
                                <option value="">Any classification</option>
                                @forelse($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option value="">No categories available</option>
                                @endforelse
                            </select>
                        </div>

                        <!-- Where Input and Search Button -->
                        <div class="md:col-span-1">
                            <label class="text-white text-lg font-semibold mb-2 block">Where</label>
                            <div class="flex gap-3">
                                <input type="text" name="location" placeholder="Enter suburb, city, or region" 
                                    class="flex-1 px-5 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 font-medium"
                                    value="{{ request('location', '') }}">
                                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-3 rounded-lg font-bold transition duration-300 transform hover:scale-105 active:scale-95 whitespace-nowrap">
                                    SEEK
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

            <p class="text-center text-black text-sm mt-6">
                🔥 Popular: PHP Developer, UI/UX Designer, Data Scientist, Marketing Manager
            </p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-white py-12 md:py-16 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-5xl md:text-6xl font-bold text-blue-600 mb-2">{{ $totalJobs }}</div>
                    <p class="text-gray-600 font-medium">Active Job Listings</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl md:text-6xl font-bold text-purple-600 mb-2">{{ $totalCompanies }}</div>
                    <p class="text-gray-600 font-medium">Hiring Companies</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl md:text-6xl font-bold text-green-600 mb-2">50k+</div>
                    <p class="text-gray-600 font-medium">Active Job Seekers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Browse by Category</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Explore job opportunities in your field of interest</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('jobs.search', ['category' => $category->id]) }}" 
                        class="p-6 bg-white border-2 border-gray-100 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all duration-300 text-center transform hover:-translate-y-1">
                        <div class="text-4xl mb-3">{{ $category->icon ?? '💼' }}</div>
                        <p class="font-semibold text-gray-900 text-sm md:text-base">{{ $category->name }}</p>
                        <p class="text-xs md:text-sm text-gray-500 mt-2 font-medium">{{ $category->jobs_count ?? 0 }} {{ ($category->jobs_count ?? 0) === 1 ? 'job' : 'jobs' }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Latest Jobs Section -->
    <div class="py-16 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Latest Job Openings</h2>
                    <p class="text-gray-600 mt-2">Recently posted positions</p>
                </div>
                <a href="{{ route('jobs.search') }}" class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center gap-2">
                    View all jobs
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($latestJobs as $job)
                    <a href="javascript:void(0)" class="job-card-link block" data-job-id="{{ $job->id }}" style="text-decoration: none; color: inherit;">
                        <x-cards.job-card :job="$job" :sidebar="true" />
                    </a>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-gray-600 text-lg font-medium">No jobs available yet</p>
                        <p class="text-gray-500 mt-2">Check back soon for new opportunities</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 md:py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to find your next opportunity?</h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">Join thousands of job seekers who've found their perfect job on Skill Issue</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('jobs.search') }}" class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition transform hover:scale-105">
                    Browse Jobs
                </a>
                @guest
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition transform hover:scale-105">
                        Create Free Account
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Include Job Detail Sidebar -->
    @include('components.job-detail-sidebar')

    <!-- Footer -->
    @include('components.footer')

    <style>
        .job-card-link {
            pointer-events: auto !important;
            cursor: pointer !important;
            text-decoration: none !important;
            color: inherit !important;
        }
    </style>

    <script>
        // Initialize job card click handlers
        function initJobCards() {
            const links = document.querySelectorAll('.job-card-link');
            
            links.forEach((link) => {
                const jobId = link.getAttribute('data-job-id');
                
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openJobDetailSidebar(jobId);
                });
            });
        }

        // Run when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initJobCards);
        } else {
            initJobCards();
        }
    </script>
</body>
</html>
