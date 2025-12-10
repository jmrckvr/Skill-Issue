<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <a href="{{ route('employer.jobs.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold mb-6 inline-block">← Back to Job Listings</a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Header Card -->
                <div class="bg-white rounded-lg shadow p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                            <p class="text-gray-700 text-lg font-semibold mb-4">{{ auth()->user()->company->name }}</p>
                        </div>
                        <div class="flex gap-4 ml-6">
                            @php
                                $logoUrl = null;
                                if ($job->logo) {
                                    if (filter_var($job->logo, FILTER_VALIDATE_URL)) {
                                        $logoUrl = $job->logo;
                                    } elseif (str_starts_with($job->logo, 'logos/') || file_exists(public_path($job->logo))) {
                                        $logoUrl = asset($job->logo);
                                    } else {
                                        $logoUrl = asset('storage/' . $job->logo);
                                    }
                                }
                            @endphp
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $job->title }}" 
                                    class="w-24 h-24 rounded object-cover" loading="lazy" decoding="async">
                            @else
                                <div class="w-24 h-24 rounded bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-2xl">{{ substr($job->title, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex items-center gap-4 mb-6">
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                            @if($job->status === 'published') bg-green-100 text-green-800
                            @elseif($job->status === 'draft') bg-yellow-100 text-yellow-800
                            @elseif($job->status === 'closed') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ ucfirst($job->job_type) }}
                        </span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            {{ ucfirst($job->experience_level) }}
                        </span>
                        @if($job->category)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $job->category->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Key Details Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6 border-t border-gray-200">
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">📍 Location</p>
                            <p class="font-bold text-gray-900 mt-1">{{ $job->location }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">💰 Salary</p>
                            <p class="font-bold text-green-600 mt-1">
                                @if($job->hide_salary)
                                    Confidential
                                @else
                                    {{ $job->currency }} {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">📅 Posted</p>
                            <p class="font-bold text-gray-900 mt-1">{{ $job->published_at?->format('M d, Y') ?? 'Draft' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">👥 Applications</p>
                            <p class="font-bold text-gray-900 mt-1">{{ $applicationCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Job Description</h2>
                    <div class="prose prose-sm max-w-none text-gray-700">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                <!-- Requirements -->
                @if($job->requirements)
                    <div class="bg-white rounded-lg shadow p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Requirements</h2>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                @endif

                <!-- Benefits -->
                @if($job->benefits)
                    <div class="bg-white rounded-lg shadow p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Benefits</h2>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            {!! nl2br(e($job->benefits)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar: Statistics & Actions -->
            <div class="space-y-6">
                <!-- Application Stats Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Application Stats</h3>
                    
                    <div class="space-y-4">
                        <!-- Total Applications -->
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Total Applications</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $applicationCount }}</p>
                            </div>
                            <div class="text-3xl">📋</div>
                        </div>

                        <!-- Pending Applications -->
                        <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Pending Review</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</p>
                            </div>
                            <div class="text-3xl">⏳</div>
                        </div>

                        <!-- Accepted Applicants -->
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Accepted</p>
                                <p class="text-2xl font-bold text-green-600">{{ $acceptedCount }}</p>
                            </div>
                            <div class="text-3xl">✅</div>
                        </div>

                        <!-- Rejected Applicants -->
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Rejected</p>
                                <p class="text-2xl font-bold text-red-600">{{ $rejectedCount }}</p>
                            </div>
                            <div class="text-3xl">❌</div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow p-6 space-y-3">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
                    
                    @if($applicationCount > 0)
                        <a href="{{ route('employer.jobs.applicants', $job) }}" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition text-center block">
                            👥 View All Applicants
                        </a>
                    @endif

                    <a href="{{ route('employer.jobs.edit', $job) }}" class="w-full bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition text-center block">
                        ✎ Edit Job
                    </a>

                    @if($job->status === 'draft')
                        <form action="{{ route('employer.jobs.publish', $job) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                                📤 Publish Job
                            </button>
                        </form>
                    @elseif($job->status === 'published')
                        <form action="{{ route('employer.jobs.close', $job) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                                🔒 Close Job
                            </button>
                        </form>
                    @endif

                    <button onclick="confirmDelete()" class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        🗑️ Delete Job
                    </button>

                    <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST" id="deleteForm" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>

                <!-- Job Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Job Information</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Posted on</span>
                            <span class="font-semibold text-gray-900">{{ $job->published_at?->format('M d, Y') ?? 'Not published' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created on</span>
                            <span class="font-semibold text-gray-900">{{ $job->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($job->closed_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Closed on</span>
                                <span class="font-semibold text-gray-900">{{ $job->closed_at->format('M d, Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
