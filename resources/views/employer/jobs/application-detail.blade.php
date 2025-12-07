<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Application Details</h1>
                <p class="text-gray-600 mt-2">Job: <span class="font-semibold">{{ $job->title }}</span></p>
            </div>
            <a href="{{ route('employer.jobs.applicants', $job) }}" class="text-blue-600 hover:text-blue-700 font-medium">← Back to Applicants</a>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6">
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6">
                <x-alert type="error">
                    {{ session('error') }}
                </x-alert>
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Applicant Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Applicant Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start gap-4 mb-6">
                        @if($application->applicant_profile_picture)
                            <img src="{{ asset('storage/' . $application->applicant_profile_picture) }}" alt="{{ $application->applicant_name }}" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl">
                                {{ substr($application->applicant_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $application->applicant_name }}</h2>
                            <p class="text-gray-600 text-sm">Applied {{ $application->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-6 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Email</p>
                            <a href="mailto:{{ $application->applicant_email }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">{{ $application->applicant_email }}</a>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Phone</p>
                            <p class="text-gray-900 font-medium text-sm">{{ $application->applicant_phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Location</p>
                            <p class="text-gray-900 font-medium text-sm">{{ $application->applicant_location ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Status</p>
                            <p class="text-gray-900 font-medium text-sm capitalize">{{ $application->status }}</p>
                        </div>
                    </div>
                </div>

                <!-- Applicant Skills & Bio -->
                @if($application->applicant_skills || $application->applicant_bio)
                    <div class="bg-white rounded-lg shadow p-6">
                        @if($application->applicant_skills)
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Skills</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $application->applicant_skills) as $skill)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($application->applicant_bio)
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-3">About</h3>
                                <p class="text-gray-700 leading-relaxed">{{ $application->applicant_bio }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Cover Letter -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Cover Letter</h3>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $application->cover_letter ?? 'No cover letter provided.' }}</p>
                    </div>
                </div>

                <!-- Application Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Application Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 bg-blue-600 rounded-full mt-2"></div>
                                <div class="w-0.5 h-16 bg-gray-200 mt-2"></div>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Application Submitted</p>
                                <p class="text-gray-600 text-sm">{{ $application->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>

                        @if($application->status !== 'pending')
                            <div class="flex items-start gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 {{ $application->status === 'accepted' ? 'bg-green-600' : 'bg-red-600' }} rounded-full mt-2"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Application {{ ucfirst($application->status) }}</p>
                                    <p class="text-gray-600 text-sm">{{ $application->updated_at->format('M d, Y \a\t H:i') }}</p>
                                    @if($application->rejection_reason)
                                        <p class="text-gray-700 mt-2 bg-red-50 p-3 rounded border border-red-200">
                                            <span class="font-semibold">Reason:</span> {{ $application->rejection_reason }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Status</h3>
                    <div class="mb-6">
                        @if($application->status === 'pending')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">Pending Review</span>
                        @elseif($application->status === 'accepted')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">Approved</span>
                        @elseif($application->status === 'rejected')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">Rejected</span>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    @if($application->status === 'pending')
                        <div class="space-y-2">
                            <form action="{{ route('employer.applicants.approve', ['job' => $job, 'application' => $application]) }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                                    ✓ Approve
                                </button>
                            </form>
                            <button type="button" onclick="openRejectModal()" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition">
                                ✗ Reject
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Resume Download -->
                @if($application->resume_path)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Resume</h3>
                        <a href="{{ route('employer.application.download-resume', ['job' => $job, 'application' => $application]) }}" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition block text-center">
                            📄 Download Resume
                        </a>
                    </div>
                @endif

                <!-- Application Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Information</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">Applied on</p>
                            <p class="font-semibold text-gray-900">{{ $application->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Job Title</p>
                            <p class="font-semibold text-gray-900">{{ $job->title }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Location</p>
                            <p class="font-semibold text-gray-900">{{ $job->location }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Application</h3>
            <p class="text-gray-600 mb-4">Provide a reason for rejection:</p>
            <form action="{{ route('employer.applicants.reject', ['job' => $job, 'application' => $application]) }}" method="POST">
                @csrf
                <textarea name="rejection_reason" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Provide feedback to the applicant..."></textarea>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Reject</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</body>
</html>
