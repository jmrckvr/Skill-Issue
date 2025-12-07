<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Jobs - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <x-navbar />

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <!-- Main Layout: Sidebar + Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <x-applicant-sidebar :user="$user" />
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-6">Activity</h1>

                        <!-- Tabs -->
                        <div class="flex gap-8 border-b border-gray-200">
                            <button onclick="switchTab('saved')" 
                                    id="savedTab"
                                    class="px-4 py-3 font-medium border-b-2 border-blue-600 text-blue-600 transition">
                                📌 Saved
                            </button>
                            <button onclick="switchTab('applied')" 
                                    id="appliedTab"
                                    class="px-4 py-3 font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 transition">
                                ⭕ Applied
                            </button>
                        </div>
                    </div>

                    <!-- Saved Jobs Tab -->
                    <div id="savedContent" class="tab-content">
                        @if($savedJobs && $savedJobs->count() > 0)
                            <div class="space-y-4">
                                @foreach($savedJobs as $savedJob)
                                    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $savedJob->job->title }}</h3>
                                                @if($savedJob->job->company)
                                                    <p class="text-gray-600 mb-3">{{ $savedJob->job->company->name }}</p>
                                                @endif
                                                <div class="flex flex-wrap gap-3 mb-4">
                                                    @if($savedJob->job->location)
                                                        <span class="text-sm text-gray-600">📍 {{ $savedJob->job->location }}</span>
                                                    @endif
                                                    @if($savedJob->job->salary_min && $savedJob->job->salary_max)
                                                        <span class="text-sm text-gray-600">💰 ${{ number_format($savedJob->job->salary_min) }} - ${{ number_format($savedJob->job->salary_max) }}</span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-600">Saved {{ $savedJob->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="flex-shrink-0 flex gap-2">
                                                <a href="{{ route('jobs.show', $savedJob->job) }}" 
                                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                                    View
                                                </a>
                                                <form action="{{ route('jobs.unsave', $savedJob->job) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded-lg transition" title="Remove from saved">
                                                        ❌
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                                <div class="mb-6">
                                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">No saved jobs yet</h2>
                                <p class="text-gray-600 mb-8">Save jobs you're interested in so you can come back to them later.</p>
                                <a href="{{ route('jobs.search') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                    Browse Jobs
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Applied Tab -->
                    <div id="appliedContent" class="tab-content hidden">
                        @if($applications && $applications->count() > 0)
                            <div class="space-y-4">
                                @foreach($applications as $app)
                                    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $app->job->title }}</h3>
                                                @if($app->job->company)
                                                    <p class="text-gray-600 mb-3">{{ $app->job->company->name }}</p>
                                                @endif
                                                <p class="text-sm text-gray-600 mb-4">Applied {{ $app->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="flex-shrink-0 text-right">
                                                <span class="inline-block px-4 py-2 rounded-full font-semibold text-sm @switch($app->application_status ?? 'pending')
                                                    @case('pending')
                                                        bg-yellow-100 text-yellow-800
                                                        @break
                                                    @case('reviewed')
                                                        bg-blue-100 text-blue-800
                                                        @break
                                                    @case('rejected')
                                                        bg-red-100 text-red-800
                                                        @break
                                                    @case('hired')
                                                        bg-green-100 text-green-800
                                                        @break
                                                    @default
                                                        bg-gray-100 text-gray-800
                                                @endswitch">
                                                    {{ ucfirst($app->application_status ?? 'pending') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                                <div class="mb-6">
                                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">No applications yet</h2>
                                <p class="text-gray-600 mb-8">Apply for jobs now and see your applications here.</p>
                                <a href="{{ route('jobs.search') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                    Apply for Jobs
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all tab contents
            document.getElementById('savedContent').classList.add('hidden');
            document.getElementById('appliedContent').classList.add('hidden');

            // Remove active state from all tabs
            document.getElementById('savedTab').classList.remove('border-blue-600', 'text-blue-600');
            document.getElementById('savedTab').classList.add('border-transparent', 'text-gray-600');
            document.getElementById('appliedTab').classList.remove('border-blue-600', 'text-blue-600');
            document.getElementById('appliedTab').classList.add('border-transparent', 'text-gray-600');

            // Show selected tab content
            if (tab === 'saved') {
                document.getElementById('savedContent').classList.remove('hidden');
                document.getElementById('savedTab').classList.remove('border-transparent', 'text-gray-600');
                document.getElementById('savedTab').classList.add('border-blue-600', 'text-blue-600');
            } else if (tab === 'applied') {
                document.getElementById('appliedContent').classList.remove('hidden');
                document.getElementById('appliedTab').classList.remove('border-transparent', 'text-gray-600');
                document.getElementById('appliedTab').classList.add('border-blue-600', 'text-blue-600');
            }
        }
    </script>
</body>
</html>
