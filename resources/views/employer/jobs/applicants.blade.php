<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applicants - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Applicants for: {{ $job->title }}</h1>
                <p class="text-gray-600 mt-2">Total Applicants: <span class="font-semibold">{{ $applicants->count() }}</span></p>
            </div>
            <a href="{{ route('employer.jobs.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">← Back to Jobs</a>
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

        <!-- Applicants Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($applicants->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Applicant</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Contact</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Location</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Applied</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applicants as $application)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($application->applicant_profile_picture)
                                                <img src="{{ asset('storage/' . $application->applicant_profile_picture) }}" alt="{{ $application->applicant_name }}" class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                                    {{ substr($application->applicant_name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $application->applicant_name }}</p>
                                                <p class="text-xs text-gray-500">ID: {{ $application->user_id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-700">{{ $application->applicant_email }}</p>
                                            <p class="text-sm text-gray-500">{{ $application->applicant_phone ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $application->applicant_location ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($application->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">Pending Review</span>
                                        @elseif($application->status === 'accepted')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">Approved</span>
                                        @elseif($application->status === 'rejected')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $application->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('employer.jobs.application-detail', ['job' => $job, 'application' => $application]) }}" 
                                                class="text-blue-600 hover:text-blue-700 font-medium text-sm px-3 py-1 border border-blue-600 rounded hover:bg-blue-50 transition">
                                                View Details
                                            </a>
                                            @if($application->status === 'pending')
                                                <form action="{{ route('employer.applicants.approve', ['job' => $job, 'application' => $application]) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-700 font-medium text-sm px-3 py-1 border border-green-600 rounded hover:bg-green-50 transition">
                                                        Approve
                                                    </button>
                                                </form>
                                                <button type="button" class="text-red-600 hover:text-red-700 font-medium text-sm px-3 py-1 border border-red-600 rounded hover:bg-red-50 transition" onclick="openRejectModal('{{ $application->id }}')">
                                                    Reject
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <p class="text-gray-600 text-lg">No applications yet for this job.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Application</h3>
            <p class="text-gray-600 mb-4">Provide a reason for rejection:</p>
            <form id="rejectForm" method="POST">
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
        function openRejectModal(applicationId) {
            const form = document.getElementById('rejectForm');
            form.action = '{{ route("employer.applicants.reject", ["job" => $job, "application" => "APPLICATION_ID"]) }}'.replace('APPLICATION_ID', applicationId);
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</body>
</html>
