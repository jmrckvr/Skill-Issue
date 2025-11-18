@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
            <p class="text-gray-600 mt-2">Track your job applications and their status</p>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 flex gap-4 overflow-x-auto">
                <a href="{{ route('jobseeker.applications') }}" class="px-4 py-2 rounded-lg whitespace-nowrap @if(!request('status')) bg-blue-100 text-blue-600 @else text-gray-600 hover:bg-gray-100 @endif">
                    All ({{ $allCount }})
                </a>
                <a href="{{ route('jobseeker.applications', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg whitespace-nowrap @if(request('status') === 'pending') bg-yellow-100 text-yellow-600 @else text-gray-600 hover:bg-gray-100 @endif">
                    Pending ({{ $pendingCount }})
                </a>
                <a href="{{ route('jobseeker.applications', ['status' => 'reviewed']) }}" class="px-4 py-2 rounded-lg whitespace-nowrap @if(request('status') === 'reviewed') bg-purple-100 text-purple-600 @else text-gray-600 hover:bg-gray-100 @endif">
                    Reviewed ({{ $reviewedCount }})
                </a>
                <a href="{{ route('jobseeker.applications', ['status' => 'accepted']) }}" class="px-4 py-2 rounded-lg whitespace-nowrap @if(request('status') === 'accepted') bg-green-100 text-green-600 @else text-gray-600 hover:bg-gray-100 @endif">
                    Accepted ({{ $acceptedCount }})
                </a>
                <a href="{{ route('jobseeker.applications', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-lg whitespace-nowrap @if(request('status') === 'rejected') bg-red-100 text-red-600 @else text-gray-600 hover:bg-gray-100 @endif">
                    Rejected ({{ $rejectedCount }})
                </a>
            </div>
        </div>

        <!-- Applications List -->
        @if($applications->count() > 0)
            <div class="space-y-6">
                @foreach($applications as $application)
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition p-6 border-l-4 @if($application->status === 'pending') border-yellow-400 @elseif($application->status === 'accepted') border-green-400 @elseif($application->status === 'rejected') border-red-400 @else border-blue-400 @endif">
                        <div class="flex justify-between items-start gap-6">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900">{{ $application->job->title }}</h3>
                                <p class="text-gray-600 mt-1">
                                    <span class="font-medium">{{ $application->job->company->name }}</span> • {{ $application->job->location }}
                                </p>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 text-sm">
                                    <div>
                                        <p class="text-gray-600">Job Type</p>
                                        <p class="font-medium text-gray-900">{{ ucfirst(str_replace('-', ' ', $application->job->job_type)) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Experience</p>
                                        <p class="font-medium text-gray-900">{{ ucfirst($application->job->experience_level) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Applied</p>
                                        <p class="font-medium text-gray-900">{{ $application->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Salary</p>
                                        <p class="font-medium text-gray-900">
                                            @if($application->job->hide_salary)
                                                Confidential
                                            @else
                                                {{ $application->job->getFormattedSalary() }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                @if($application->rejection_reason && $application->status === 'rejected')
                                    <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                                        <p class="text-sm text-red-700"><strong>Feedback:</strong></p>
                                        <p class="text-red-600 text-sm mt-1">{{ $application->rejection_reason }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="text-right">
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
                                    <a href="{{ route('jobs.show', $application->job) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                        View Job
                                    </a>

                                    @if($application->status !== 'withdrawn' && $application->status !== 'accepted' && $application->status !== 'rejected')
                                        <button type="button" onclick="confirmWithdraw({{ $application->id }})" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                            Withdraw Application
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
                {{ $applications->appends(request()->query())->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No applications yet</h3>
                <p class="mt-1 text-gray-600">Start exploring jobs and submit your applications.</p>
                <a href="{{ route('jobs.search') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Browse Jobs
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Withdraw Confirmation Modal -->
<div id="withdrawModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Withdraw Application?</h2>
        <p class="text-gray-600 mb-6">Are you sure you want to withdraw this application? This action cannot be undone.</p>

        <form id="withdrawForm" method="POST" class="flex gap-4">
            @csrf
            <button type="button" onclick="closeWithdrawModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Cancel
            </button>
            <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Withdraw
            </button>
        </form>
    </div>
</div>

<script>
    function confirmWithdraw(applicationId) {
        document.getElementById('withdrawForm').action = `/applications/${applicationId}/withdraw`;
        document.getElementById('withdrawModal').classList.remove('hidden');
    }

    function closeWithdrawModal() {
        document.getElementById('withdrawModal').classList.add('hidden');
    }
</script>
@endsection
