@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Job Applications</h1>
                    <p class="text-gray-600 mt-2">{{ $job->title }} - {{ $applicants->total() }} applications</p>
                </div>
                <a href="{{ route('employer.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    ← Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6">
                <div class="flex gap-4">
                    <a href="{{ route('jobs.applicants', $job) }}" class="px-4 py-2 rounded-lg @if(!request('status')) bg-blue-100 text-blue-600 @else text-gray-600 hover:bg-gray-100 @endif">
                        All ({{ $job->applications()->count() }})
                    </a>
                    <a href="{{ route('jobs.applicants', ['job' => $job, 'status' => 'pending']) }}" class="px-4 py-2 rounded-lg @if(request('status') === 'pending') bg-yellow-100 text-yellow-600 @else text-gray-600 hover:bg-gray-100 @endif">
                        Pending ({{ $job->applications()->where('status', 'pending')->count() }})
                    </a>
                    <a href="{{ route('jobs.applicants', ['job' => $job, 'status' => 'reviewed']) }}" class="px-4 py-2 rounded-lg @if(request('status') === 'reviewed') bg-purple-100 text-purple-600 @else text-gray-600 hover:bg-gray-100 @endif">
                        Reviewed ({{ $job->applications()->where('status', 'reviewed')->count() }})
                    </a>
                    <a href="{{ route('jobs.applicants', ['job' => $job, 'status' => 'accepted']) }}" class="px-4 py-2 rounded-lg @if(request('status') === 'accepted') bg-green-100 text-green-600 @else text-gray-600 hover:bg-gray-100 @endif">
                        Accepted ({{ $job->applications()->where('status', 'accepted')->count() }})
                    </a>
                    <a href="{{ route('jobs.applicants', ['job' => $job, 'status' => 'rejected']) }}" class="px-4 py-2 rounded-lg @if(request('status') === 'rejected') bg-red-100 text-red-600 @else text-gray-600 hover:bg-gray-100 @endif">
                        Rejected ({{ $job->applications()->where('status', 'rejected')->count() }})
                    </a>
                </div>
            </div>
        </div>

        <!-- Applicants List -->
        @if($applicants->count() > 0)
            <div class="space-y-6">
                @foreach($applicants as $application)
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition p-6 border-l-4 @if($application->status === 'pending') border-yellow-400 @elseif($application->status === 'accepted') border-green-400 @elseif($application->status === 'rejected') border-red-400 @else border-blue-400 @endif">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900">{{ $application->user->name }}</h3>
                                <p class="text-gray-600 mt-1">
                                    <span class="font-medium">Applied:</span> {{ $application->created_at->format('M d, Y') }}
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-medium">Email:</span> {{ $application->user->email }}
                                </p>
                                @if($application->cover_letter)
                                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-600"><strong>Cover Letter:</strong></p>
                                        <p class="text-gray-700 text-sm mt-2">{{ Str::limit($application->cover_letter, 200) }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-6 text-right">
                                <!-- Status Badge -->
                                @if($application->status === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Pending</span>
                                @elseif($application->status === 'reviewed')
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">Reviewed</span>
                                @elseif($application->status === 'accepted')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Accepted</span>
                                @elseif($application->status === 'rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Rejected</span>
                                @endif

                                <!-- Action Buttons -->
                                <div class="mt-4 space-y-2 flex flex-col">
                                    <a href="{{ route('application.download-resume', $application) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                        📄 Download Resume
                                    </a>

                                    @if($application->status === 'pending' || $application->status === 'reviewed')
                                        <button type="button" onclick="openStatusModal({{ $application->id }}, 'reviewed')" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                            ✓ Mark as Reviewed
                                        </button>
                                        <button type="button" onclick="openStatusModal({{ $application->id }}, 'accepted')" class="text-green-600 hover:text-green-700 font-medium text-sm">
                                            ✓ Accept
                                        </button>
                                        <button type="button" onclick="openStatusModal({{ $application->id }}, 'rejected')" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                            ✗ Reject
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $applicants->appends(request()->query())->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No applications yet</h3>
                <p class="mt-1 text-gray-600">This job hasn't received any applications.</p>
            </div>
        @endif
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Update Application Status</h2>

        <form id="statusForm" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" id="applicationId" name="application_id">
            <input type="hidden" id="statusInput" name="status">

            <div>
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason (optional)</label>
                <textarea id="rejection_reason" name="rejection_reason" rows="4" 
                          class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Provide feedback to the applicant..."></textarea>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeStatusModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openStatusModal(applicationId, status) {
        document.getElementById('applicationId').value = applicationId;
        document.getElementById('statusInput').value = status;
        document.getElementById('rejection_reason').style.display = (status === 'rejected') ? 'block' : 'none';
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }

    document.getElementById('statusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const applicationId = document.getElementById('applicationId').value;
        this.action = `/applications/${applicationId}/status`;
        this.submit();
    });
</script>
@endsection
