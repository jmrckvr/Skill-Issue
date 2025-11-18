<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('components.navbar')

    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('jobs.search') }}" class="text-blue-600 hover:text-blue-800 mb-4">← Back to search</a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-semibold">
                                        {{ ucfirst($job->job_type) }}
                                    </span>
                                    <span class="inline-block bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-semibold">
                                        {{ ucfirst($job->experience_level) }}
                                    </span>
                                    @if($job->category)
                                        <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold">
                                            {{ $job->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($job->company->logo_path)
                                <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}"
                                    class="w-24 h-24 rounded object-cover">
                            @endif
                        </div>

                        <!-- Key Details -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 pb-8 border-b">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Location</p>
                                <p class="font-semibold">{{ $job->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Salary</p>
                                <p class="font-semibold text-green-600">{{ $job->getFormattedSalary() }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Posted</p>
                                <p class="font-semibold">{{ $job->published_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Applications</p>
                                <p class="font-semibold">{{ $job->application_count }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Job Description</h2>
                            <div class="prose prose-sm max-w-none">
                                {!! nl2br(e($job->description)) !!}
                            </div>
                        </div>

                        <!-- Requirements -->
                        @if($job->requirements)
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Requirements</h2>
                                <div class="prose prose-sm max-w-none">
                                    {!! nl2br(e($job->requirements)) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Benefits -->
                        @if($job->benefits)
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Benefits</h2>
                                <div class="prose prose-sm max-w-none">
                                    {!! nl2br(e($job->benefits)) !!}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Related Jobs -->
                    @if($relatedJobs->count() > 0)
                        <div class="bg-white rounded-lg shadow-lg p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Jobs</h2>
                            <div class="space-y-4">
                                @foreach($relatedJobs as $related)
                                    <a href="{{ route('jobs.show', $related) }}" class="block p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $related->title }}</h3>
                                                <p class="text-sm text-gray-600 mt-1">{{ $related->location }}</p>
                                            </div>
                                            <span class="text-green-600 font-semibold">{{ $related->getFormattedSalary() }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Company Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">About Company</h3>
                        
                        @if($job->company->logo_path)
                            <img src="{{ asset('storage/' . $job->company->logo_path) }}" alt="{{ $job->company->name }}"
                                class="w-full h-32 rounded object-cover mb-4">
                        @endif

                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $job->company->name }}</h4>

                        @if($job->company->description)
                            <p class="text-gray-600 text-sm mb-4">{{ $job->company->description }}</p>
                        @endif

                        <div class="space-y-2 mb-6 text-sm text-gray-600">
                            @if($job->company->industry)
                                <p><span class="font-semibold">Industry:</span> {{ $job->company->industry }}</p>
                            @endif
                            @if($job->company->employee_count)
                                <p><span class="font-semibold">Size:</span> {{ $job->company->employee_count }}+ employees</p>
                            @endif
                            @if($job->company->location)
                                <p><span class="font-semibold">Location:</span> {{ $job->company->city }}, {{ $job->company->state }}</p>
                            @endif
                        </div>

                        @if($job->company->website)
                            <a href="{{ $job->company->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                Visit company website →
                            </a>
                        @endif
                    </div>

                    <!-- Apply Section -->
                    @auth
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <button onclick="showApplyModal()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition mb-4">
                                Apply Now
                            </button>
                            <form action="{{ route('jobs.save', $job) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 rounded-lg transition">
                                    {{ $isSaved ? '★ Saved' : '☆ Save Job' }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <p class="text-gray-700 mb-4">Want to apply for this job?</p>
                            <a href="{{ route('login') }}" class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition mb-2">
                                Login to Apply
                            </a>
                            <a href="{{ route('register') }}" class="w-full block text-center bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 rounded-lg transition">
                                Create Account
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Apply Modal -->
    @auth
        <div id="applyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg max-w-md w-full mx-4 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Apply for this job</h2>
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Resume <span class="text-red-500">*</span></label>
                        <input type="file" name="resume" required accept=".pdf,.doc,.docx"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">PDF, DOC, or DOCX (Max 5MB)</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cover Letter</label>
                        <textarea name="cover_letter" rows="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Tell the employer why you're interested in this position..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition mb-2">
                        Submit Application
                    </button>
                    <button type="button" onclick="closeApplyModal()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 rounded-lg transition">
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
        }
        
        function closeApplyModal() {
            document.getElementById('applyModal').classList.add('hidden');
        }
    </script>
</body>
</html>
