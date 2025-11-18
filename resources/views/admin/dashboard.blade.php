@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600 mt-2">Manage the job board, users, and content</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 10a3 3 0 11-6 0 3 3 0 016 0zM12 14c0 1 1 2 3 2s3-1 3-2-1-2-3-2-3 1-3 2zM14 9a1 1 0 100-2 1 1 0 000 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 7H7v6h6V7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Total Jobs</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalJobs }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 9a2 2 0 11-4 0 2 2 0 014 0zm0 0a6 6 0 1112 0 6 6 0 01-12 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Published</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $publishedJobs }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Applications</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalApplications }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Companies</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalCompanies }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Navigation -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Management Tools</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.users') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <p class="font-medium text-gray-900">Manage Users</p>
                    <p class="text-sm text-gray-600 mt-1">View, search, and deactivate users</p>
                </a>
                <a href="{{ route('admin.jobs') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <p class="font-medium text-gray-900">Manage Jobs</p>
                    <p class="text-sm text-gray-600 mt-1">Review, restore, or delete job listings</p>
                </a>
                <a href="{{ route('admin.categories') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <p class="font-medium text-gray-900">Categories</p>
                    <p class="text-sm text-gray-600 mt-1">Add, edit, or remove job categories</p>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <p class="font-medium text-gray-900">New Category</p>
                    <p class="text-sm text-gray-600 mt-1">Create a new job category</p>
                </a>
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Recent Jobs</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentJobs as $job)
                        <div class="p-4 hover:bg-gray-50">
                            <p class="font-medium text-gray-900">{{ $job->title }}</p>
                            <p class="text-sm text-gray-600">{{ $job->company->name }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs px-2 py-1 rounded-full @if($job->status === 'published') bg-green-100 text-green-800 @elseif($job->status === 'draft') bg-gray-100 text-gray-800 @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($job->status) }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $job->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-600">No jobs yet</div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Recent Users</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentUsers as $user)
                        <div class="p-4 hover:bg-gray-50">
                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs px-2 py-1 rounded-full @if($user->role === 'admin') bg-red-100 text-red-800 @elseif($user->role === 'employer') bg-blue-100 text-blue-800 @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-600">No users yet</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
