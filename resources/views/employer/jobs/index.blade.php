<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Jobs - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Job Listings</h1>
                <p class="text-gray-600 mt-2">Manage all your job postings</p>
            </div>
            <a href="{{ route('employer.jobs.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                ➕ Post New Job
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex justify-between items-center">
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
                <button onclick="this.parentElement.style.display='none';" class="text-green-600 hover:text-green-800">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex justify-between items-center">
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
                <button onclick="this.parentElement.style.display='none';" class="text-red-600 hover:text-red-800">✕</button>
            </div>
        @endif

        <!-- Jobs Table/List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Logo</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Job Title</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Location</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Applications</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Posted</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($jobs as $job)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    @php
                                        $logoUrl = null;
                                        if ($job->logo) {
                                            $logoUrl = str_starts_with($job->logo, 'http') ? $job->logo : asset('storage/' . $job->logo);
                                        }
                                    @endphp
                                    @if($logoUrl)
                                        <img src="{{ $logoUrl }}" alt="{{ $job->title }}" class="w-12 h-12 rounded object-cover" loading="lazy" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2248%22 height=%2248%22 viewBox=%220 0 48 48%22%3E%3Crect width=%2248%22 height=%2248%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                                    @else
                                        <div class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 text-xs font-semibold">No Logo</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <h3 class="font-semibold text-gray-900">{{ $job->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $job->category->name ?? 'Uncategorized' }}</p>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $job->location }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        @if($job->status === 'published') bg-green-100 text-green-800
                                        @elseif($job->status === 'draft') bg-gray-100 text-gray-800
                                        @elseif($job->status === 'closed') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold text-blue-600">{{ $job->applications->count() }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $job->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('employer.jobs.applicants', $job) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                            👥 Applicants
                                        </a>
                                        <a href="{{ route('employer.jobs.edit', $job) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                            ✎ Edit
                                        </a>
                                        <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-600">
                                    <p class="text-lg mb-4">No job listings yet.</p>
                                    <a href="{{ route('employer.jobs.create') }}" class="text-blue-600 hover:underline font-medium">Create your first job posting</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($jobs->hasPages())
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</body>
</html>
