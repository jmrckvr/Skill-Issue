<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600">Here's your job search dashboard</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Saved Jobs</p>
                <p class="text-3xl font-bold text-blue-600">0</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Applications</p>
                <p class="text-3xl font-bold text-green-600">0</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Profile Views</p>
                <p class="text-3xl font-bold text-purple-600">0</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 text-sm">Active Searches</p>
                <p class="text-3xl font-bold text-orange-600">0</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column (2/3 width) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Recommended Jobs Section -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">Recommended for You</h2>
                        <p class="text-blue-100 text-sm mt-1">Jobs tailored to your profile</p>
                    </div>
                    <div class="p-6">
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <p class="mt-4 text-gray-600">No recommendations yet. Start by browsing jobs or completing your profile.</p>
                            <a href="{{ route('jobs.search') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-semibold">
                                Browse Jobs →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (1/3 width) -->
            <div class="space-y-8">
                <!-- Saved Jobs Section -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-600 to-pink-700 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">Saved Jobs</h2>
                        <p class="text-pink-100 text-sm mt-1">0 jobs</p>
                    </div>
                    <div class="p-6">
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z" />
                            </svg>
                            <p class="mt-2 text-gray-600 text-sm">No saved jobs yet</p>
                            <a href="{{ route('jobs.search') }}" class="mt-2 text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                Start saving →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('jobs.search') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition text-blue-600 font-semibold">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Browse Jobs
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition text-purple-600 font-semibold">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Update Profile
                        </a>
                    </div>
                </div>

                <!-- Category Shortcuts -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Browse by Category</h3>
                    <div class="space-y-2">
                        <a href="{{ route('jobs.search', ['category' => 'IT']) }}" class="block p-2 text-sm font-semibold text-blue-600 hover:text-blue-800">
                            → IT
                        </a>
                        <a href="{{ route('jobs.search', ['category' => 'Sales']) }}" class="block p-2 text-sm font-semibold text-green-600 hover:text-green-800">
                            → Sales
                        </a>
                        <a href="{{ route('jobs.search', ['category' => 'Marketing']) }}" class="block p-2 text-sm font-semibold text-purple-600 hover:text-purple-800">
                            → Marketing
                        </a>
                        <a href="{{ route('jobs.search', ['category' => 'HR']) }}" class="block p-2 text-sm font-semibold text-orange-600 hover:text-orange-800">
                            → HR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
