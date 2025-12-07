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
        <a href="{{ route('jobs.search') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold mb-6 inline-block">← Back to Job Search</a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Header Card -->
                <div class="bg-white rounded-lg shadow p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                            <p class="text-gray-700 text-lg font-semibold mb-4">{{ $job->company->name }}</p>
                        </div>
                        <div class="flex gap-4 ml-6">
                            @php
                                $companyLogoUrl = null;
                                if ($job->company->logo_path) {
                                    if (filter_var($job->company->logo_path, FILTER_VALIDATE_URL)) {
                                        $companyLogoUrl = $job->company->logo_path;
                                    } elseif (str_starts_with($job->company->logo_path, 'logos/')) {
                                        $companyLogoUrl = asset($job->company->logo_path);
                                    } else {
                                        $companyLogoUrl = asset('storage/' . $job->company->logo_path);
                                    }
                                }
                            @endphp
                            @if($companyLogoUrl)
                                <img src="{{ $companyLogoUrl }}" alt="{{ $job->company->name }}" 
                                    class="w-24 h-24 rounded object-cover" loading="lazy" decoding="async" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2296%22 height=%2296%22 viewBox=%220 0 96 96%22%3E%3Crect width=%2296%22 height=%2296%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                            @else
                                <div class="w-24 h-24 rounded bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-2xl">{{ substr($job->company->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
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
                            <p class="font-bold text-green-600 mt-1">{{ $job->getFormattedSalary() }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">📅 Posted</p>
                            <p class="font-bold text-gray-900 mt-1">{{ $job->published_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">👥 Applications</p>
                            <p class="font-bold text-gray-900 mt-1">{{ $job->application_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Job Description</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                <!-- Requirements -->
                @if($job->requirements)
                    <div class="bg-white rounded-lg shadow p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Requirements</h2>
                        <div class="text-gray-700 space-y-4 leading-relaxed">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                @endif

                <!-- Benefits -->
                @if($job->benefits)
                    <div class="bg-white rounded-lg shadow p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Benefits</h2>
                        <div class="text-gray-700 space-y-4 leading-relaxed">
                            {!! nl2br(e($job->benefits)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1 space-y-6 h-fit lg:sticky lg:top-24">
                <!-- Apply Section -->
                @auth
                    <div class="bg-white rounded-lg shadow p-6">
                        <button type="button" onclick="window.location.href='{{ route('applications.apply', $job) }}'" style="display: block; background-color: #f53a6b; color: white; padding: 12px 16px; border-radius: 6px; font-weight: 700; width: 100%; border: none; cursor: pointer; transition: background-color 0.3s; margin-bottom: 12px; font-size: 15px; text-align: center;">
                            Apply Now
                        </button>
                        <button type="button" id="saveJobBtn" onclick="toggleSaveJob(event, {{ $job->id }})" style="background-color: {{ $isSaved ? '#f59e0b' : '#f3f4f6' }}; color: {{ $isSaved ? 'white' : '#1f2937' }}; padding: 12px 16px; border-radius: 6px; font-weight: 700; width: 100%; border: none; cursor: pointer; transition: all 0.3s;" data-saved="{{ $isSaved ? 'true' : 'false' }}">
                            {{ $isSaved ? '★ Saved' : '☆ Save Job' }}
                        </button>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-gray-900 font-semibold mb-4">Want to apply for this job?</p>
                        <a href="{{ route('login') }}" style="display: block; background-color: #2563eb; color: white; padding: 12px 16px; border-radius: 6px; font-weight: 700; text-align: center; text-decoration: none; margin-bottom: 10px; transition: background-color 0.3s;">
                            Login to Apply
                        </a>
                        <a href="{{ route('register') }}" style="display: block; background-color: #f3f4f6; color: #1f2937; padding: 12px 16px; border-radius: 6px; font-weight: 700; text-align: center; text-decoration: none; border: 1px solid #d1d5db; transition: all 0.3s;">
                            Create Account
                        </a>
                    </div>
                @endauth

                <!-- Company Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">About Company</h3>
                    @php
                        $companyLogoUrl = null;
                        if ($job->company->logo_path) {
                            if (filter_var($job->company->logo_path, FILTER_VALIDATE_URL)) {
                                $companyLogoUrl = $job->company->logo_path;
                            } elseif (str_starts_with($job->company->logo_path, 'logos/')) {
                                $companyLogoUrl = asset($job->company->logo_path);
                            } else {
                                $companyLogoUrl = asset('storage/' . $job->company->logo_path);
                            }
                        }
                    @endphp
                    
                    @if($companyLogoUrl)
                        <img src="{{ $companyLogoUrl }}" alt="{{ $job->company->name }}" 
                            class="w-full h-32 rounded-lg object-cover mb-4" loading="lazy" decoding="async" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22128%22 viewBox=%220 0 400 128%22%3E%3Crect width=%22400%22 height=%22128%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                    @else
                        <div class="w-full h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg mb-4 flex items-center justify-center">
                            <span class="text-white font-bold text-4xl">{{ substr($job->company->name, 0, 1) }}</span>
                        </div>
                    @endif

                    <h4 class="text-base font-bold text-gray-900 mb-3">{{ $job->company->name }}</h4>

                    @if($job->company->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $job->company->description }}</p>
                    @endif

                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        @if($job->company->industry)
                            <div><span class="font-semibold">Industry:</span> {{ $job->company->industry }}</div>
                        @endif
                        @if($job->company->employee_count)
                            <div><span class="font-semibold">Size:</span> {{ $job->company->employee_count }}+ employees</div>
                        @endif
                        @if($job->company->city)
                            <div><span class="font-semibold">Location:</span> {{ $job->company->city }}{{ $job->company->state ? ', ' . $job->company->state : '' }}</div>
                        @endif
                    </div>

                    @if($job->company->website)
                        <a href="{{ $job->company->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Visit website →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script>
        function toggleSaveJob(e, jobId) {
            e.preventDefault();
            if (!jobId) jobId = {{ $job->id }};
            
            const btn = document.getElementById('saveJobBtn');
            const isSaved = btn.dataset.saved === 'true';
            const url = isSaved ? `/api/jobs/${jobId}/save` : `/api/jobs/${jobId}/save`;
            const method = isSaved ? 'DELETE' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newSavedState = !isSaved;
                    btn.dataset.saved = newSavedState ? 'true' : 'false';
                    btn.textContent = newSavedState ? '★ Saved' : '☆ Save Job';
                    btn.style.backgroundColor = newSavedState ? '#f59e0b' : '#f3f4f6';
                    btn.style.color = newSavedState ? 'white' : '#1f2937';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save job. Please try again.');
            });
        }
    </script>
</body>
</html>
