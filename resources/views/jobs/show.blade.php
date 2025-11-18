<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Breadcrumb -->
        <a href="{{ route('jobs.search') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold mb-6 inline-block">← Back to Job Search</a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (Left/Center) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header Card -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex-1">
                            <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $job->title }}</h1>
                            <p class="text-xl text-gray-600 mb-4">{{ $job->company->name }}</p>
                            
                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    {{ ucfirst($job->job_type) }}
                                </span>
                                <span class="inline-block px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-semibold">
                                    {{ ucfirst($job->experience_level) }}
                                </span>
                                @if($job->category)
                                    <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                        {{ $job->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Company Logo -->
                        @if($job->company->logo_path)
                            <div class="ml-6">
                                <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" 
                                    class="w-32 h-32 rounded-lg object-cover shadow">
                            </div>
                        @endif
                    </div>

                    <!-- Quick Details -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">📍 Location</p>
                            <p class="font-bold text-gray-900 mt-1">{{ $job->location }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">💰 Salary</p>
                            <p class="font-bold text-green-600 mt-1">{{ $job->getFormattedSalary() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">📅 Posted</p>
                            <p class="font-bold text-gray-900 mt-1">{{ $job->published_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">👥 Applications</p>
                            <p class="font-bold text-gray-900 mt-1">{{ $job->application_count ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Job Description</h2>
                    <div class="prose prose-lg max-w-none text-gray-700 mb-8">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                <!-- Requirements -->
                @if($job->requirements)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Requirements</h2>
                        <div class="prose prose-lg max-w-none text-gray-700">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                @endif

                <!-- Benefits -->
                @if($job->benefits)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Benefits</h2>
                        <div class="prose prose-lg max-w-none text-gray-700">
                            {!! nl2br(e($job->benefits)) !!}
                        </div>
                    </div>
                @endif

                <!-- Related Jobs -->
                @if($relatedJobs && $relatedJobs->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Similar Jobs</h2>
                        <div class="space-y-4">
                            @foreach($relatedJobs->take(3) as $related)
                                <a href="{{ route('jobs.show', $related) }}" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900">{{ $related->title }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">{{ $related->company->name }} • {{ $related->location }}</p>
                                        </div>
                                        <span class="text-green-600 font-bold whitespace-nowrap ml-4">{{ $related->getFormattedSalary() }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar (Right) - Sticky -->
            <div class="lg:col-span-1 space-y-6 h-fit lg:sticky lg:top-24">
                <!-- Apply Section -->
                @auth
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <button onclick="showApplyModal()" style="background-color: #2563eb; color: white; padding: 14px 16px; border-radius: 8px; font-weight: 700; width: 100%; border: none; cursor: pointer; transition: background-color 0.3s; margin-bottom: 12px; font-size: 16px;">
                            Quick Apply
                        </button>
                        <form action="{{ route('jobs.save', $job) }}" method="POST">
                            @csrf
                            <button type="submit" style="background-color: {{ $isSaved ? '#f59e0b' : '#f3f4f6' }}; color: {{ $isSaved ? 'white' : '#1f2937' }}; padding: 14px 16px; border-radius: 8px; font-weight: 700; width: 100%; border: none; cursor: pointer; transition: all 0.3s;">
                                {{ $isSaved ? '★ Saved' : '☆ Save Job' }}
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <p class="text-gray-900 font-semibold mb-4">Interested in this job?</p>
                        <a href="{{ route('login') }}" style="display: block; background-color: #2563eb; color: white; padding: 12px 16px; border-radius: 8px; font-weight: 700; text-align: center; text-decoration: none; margin-bottom: 10px; transition: background-color 0.3s;">
                            Login to Apply
                        </a>
                        <a href="{{ route('register') }}" style="display: block; background-color: #f3f4f6; color: #1f2937; padding: 12px 16px; border-radius: 8px; font-weight: 700; text-align: center; text-decoration: none; border: 1px solid #d1d5db; transition: all 0.3s;">
                            Create Account
                        </a>
                    </div>
                @endauth

                <!-- Company Card -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">About Company</h3>
                    
                    @if($job->company->logo_path)
                        <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}" 
                            class="w-full h-40 rounded-lg object-cover mb-4">
                    @else
                        <div class="w-full h-40 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg mb-4 flex items-center justify-center">
                            <span class="text-white font-bold text-4xl">{{ substr($job->company->name, 0, 1) }}</span>
                        </div>
                    @endif

                    <h4 class="text-lg font-bold text-gray-900 mb-3">{{ $job->company->name }}</h4>

                    @if($job->company->description)
                        <p class="text-gray-700 text-sm mb-4 line-clamp-3">{{ $job->company->description }}</p>
                    @endif

                    <div class="space-y-3 mb-6 text-sm">
                        @if($job->company->industry)
                            <div class="flex items-center text-gray-700">
                                <span class="font-semibold">Industry:</span>
                                <span class="ml-2">{{ $job->company->industry }}</span>
                            </div>
                        @endif
                        @if($job->company->employee_count)
                            <div class="flex items-center text-gray-700">
                                <span class="font-semibold">Size:</span>
                                <span class="ml-2">{{ $job->company->employee_count }}+ employees</span>
                            </div>
                        @endif
                        @if($job->company->city || $job->company->state)
                            <div class="flex items-center text-gray-700">
                                <span class="font-semibold">Location:</span>
                                <span class="ml-2">{{ $job->company->city }}{{ $job->company->state ? ', ' . $job->company->state : '' }}</span>
                            </div>
                        @endif
                    </div>

                    @if($job->company->website)
                        <a href="{{ $job->company->website }}" target="_blank" class="inline-block text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Visit website →
                        </a>
                    @endif
                </div>

                <!-- Share Section -->
                <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                    <h3 class="text-sm font-bold text-blue-900 mb-3 uppercase tracking-wider">Share This Job</h3>
                    <div class="space-y-2">
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('jobs.show', $job)) }}" target="_blank" 
                            class="flex items-center text-blue-700 hover:text-blue-900 text-sm font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20.5 2h-17A1.5 1.5 0 002 3.5v17A1.5 1.5 0 003.5 22h17a1.5 1.5 0 001.5-1.5v-17A1.5 1.5 0 0020.5 2zM8 19H5v-9h3zM6.5 8.25A1.75 1.75 0 118.3 6.5a1.78 1.78 0 01-1.8 1.75zM19 19h-3v-4.74c0-1.42-.6-1.93-1.38-1.93A1.74 1.74 0 0013 14.19a.66.66 0 000 .14V19h-3v-9h2.9v1.3a3.11 3.11 0 012.7-1.4c1.55 0 3.36.86 3.36 3.66z"/></svg>
                            Share on LinkedIn
                        </a>
                        <button onclick="copyLink()" class="flex items-center text-blue-700 hover:text-blue-900 text-sm font-semibold w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Apply Modal -->
    @auth
        <div id="applyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-8 shadow-2xl">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Apply for this job</h2>
                <p class="text-gray-600 text-sm mb-6">{{ $job->title }} at {{ $job->company->name }}</p>
                
                <form action="{{ route('applications.store', $job) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Resume <span class="text-red-500">*</span></label>
                        <input type="file" name="resume" required accept=".pdf,.doc,.docx"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">PDF, DOC, or DOCX (Max 5MB)</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Cover Letter</label>
                        <textarea name="cover_letter" rows="4" placeholder="Tell the employer why you're interested in this position..."
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                    </div>

                    <button type="submit" style="background-color: #2563eb; color: white; padding: 12px 16px; border-radius: 8px; font-weight: 700; width: 100%; border: none; cursor: pointer; margin-bottom: 10px; font-size: 16px;">
                        Submit Application
                    </button>
                    <button type="button" onclick="closeApplyModal()" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg text-gray-900 font-semibold hover:bg-gray-50">
                        Cancel
                    </button>
                </form>
            </div>
        </div>
    @endauth

    @include('components.footer')

    <script>
        function showApplyModal() {
            document.getElementById('applyModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeApplyModal() {
            document.getElementById('applyModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copied to clipboard!');
            });
        }

        // Close modal when clicking outside
        document.getElementById('applyModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeApplyModal();
            }
        });
    </script>
</body>
</html>
