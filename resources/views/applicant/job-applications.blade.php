<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications - Skill Issue</title>
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
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">Job Applications</h1>
                        <p class="text-gray-600">Track the status of all your job applications</p>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="mb-8 flex flex-wrap gap-3">
                        <button onclick="filterApplications('all')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-blue-600 text-white" 
                                data-filter="all">
                            All
                        </button>
                        <button onclick="filterApplications('pending')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-white border border-gray-300 text-gray-700 hover:bg-gray-50" 
                                data-filter="pending">
                            ⏳ Pending
                        </button>
                        <button onclick="filterApplications('reviewed')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-white border border-gray-300 text-gray-700 hover:bg-gray-50" 
                                data-filter="reviewed">
                            👀 Reviewed
                        </button>
                        <button onclick="filterApplications('rejected')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-white border border-gray-300 text-gray-700 hover:bg-gray-50" 
                                data-filter="rejected">
                            ❌ Rejected
                        </button>
                        <button onclick="filterApplications('hired')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-white border border-gray-300 text-gray-700 hover:bg-gray-50" 
                                data-filter="hired">
                            ✅ Hired
                        </button>
                    </div>

                    <!-- Applications List -->
                    @if($applications && $applications->count() > 0)
                        <div class="space-y-4">
                            @foreach($applications as $app)
                                <div class="applicationCard bg-white rounded-lg border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition" 
                                     data-status="{{ $app->status ?? 'pending' }}">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-start gap-4 mb-3">
                                                @if($app->job->company && $app->job->company->logo_path)
                                                    <img src="{{ asset('storage/' . $app->job->company->logo_path) }}" 
                                                         alt="{{ $app->job->company->name }}"
                                                         class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold border border-gray-200">
                                                        {{ substr($app->job->company->name ?? 'J', 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $app->job->title }}</h3>
                                                    @if($app->job->company)
                                                        <p class="text-gray-600 font-medium">{{ $app->job->company->name }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap gap-3 mb-4">
                                                @if($app->job->location)
                                                    <span class="text-sm text-gray-600">📍 {{ $app->job->location }}</span>
                                                @endif
                                            </div>

                                            <div class="space-y-1 text-sm text-gray-600">
                                                <p>Applied <span class="font-medium">{{ $app->created_at->format('M d, Y') }}</span></p>
                                                @if($app->updated_at->ne($app->created_at))
                                                    <p>Last updated <span class="font-medium">{{ $app->updated_at->diffForHumans() }}</span></p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex-shrink-0 text-right flex flex-col gap-3">
                                            <span class="inline-block px-4 py-2 rounded-full font-semibold text-sm @switch($app->status ?? 'pending')
                                                @case('pending')
                                                    bg-yellow-100 text-yellow-800
                                                    @break
                                                @case('reviewed')
                                                    bg-blue-100 text-blue-800
                                                    @break
                                                @case('accepted')
                                                    bg-green-100 text-green-800
                                                    @break
                                                @case('rejected')
                                                    bg-red-100 text-red-800
                                                    @break
                                                @default
                                                    bg-gray-100 text-gray-800
                                            @endswitch">
                                                @switch($app->status ?? 'pending')
                                                    @case('pending')
                                                        ⏳ Pending
                                                        @break
                                                    @case('reviewed')
                                                        👀 Reviewed
                                                        @break
                                                    @case('accepted')
                                                        ✅ Approved
                                                        @break
                                                    @case('rejected')
                                                        ❌ Rejected
                                                        @break
                                                    @default
                                                        Pending
                                                @endswitch
                                            </span>
                                            <a href="{{ route('jobs.show', $app->job) }}" 
                                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition text-sm text-center">
                                                View Job
                                            </a>
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
                            <p class="text-gray-600 mb-8">Start applying for jobs and track your applications here.</p>
                            <a href="{{ route('jobs.search') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                Browse Jobs
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterApplications(status) {
            const cards = document.querySelectorAll('.applicationCard');
            const buttons = document.querySelectorAll('.filterBtn');

            // Update button styles
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-700', 'hover:bg-gray-50');
            });

            // Mark active button
            const activeBtn = Array.from(buttons).find(btn => btn.dataset.filter === status);
            if (activeBtn) {
                activeBtn.classList.add('bg-blue-600', 'text-white');
                activeBtn.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-700', 'hover:bg-gray-50');
            }

            // Filter cards
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
