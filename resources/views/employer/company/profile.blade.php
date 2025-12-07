<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Company Profile</h1>
                <p class="text-gray-600 mt-2">{{ $company->name }}</p>
            </div>
            <a href="{{ route('employer.company.edit') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                Edit Profile
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Company Logo -->
                @if($company->logo_path)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Company Logo</h2>
                        @php
                            $companyLogoUrl = str_starts_with($company->logo_path, 'http') ? $company->logo_path : asset('storage/' . $company->logo_path);
                        @endphp
                        <img src="{{ $companyLogoUrl }}" alt="{{ $company->name }}" class="h-40 w-40 object-contain" loading="lazy" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22160%22 height=%22160%22 viewBox=%220 0 160 160%22%3E%3Crect width=%22160%22 height=%22160%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                    </div>
                @endif

                <!-- Company Description -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">About Company</h2>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $company->description ?? 'No description provided.' }}</p>
                </div>

                <!-- Company Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Company Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 text-sm">Company Name</p>
                            <p class="text-gray-900 font-semibold">{{ $company->name }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Industry</p>
                            <p class="text-gray-900 font-semibold">{{ $company->industry ?? 'Not specified' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Email Address</p>
                            <a href="mailto:{{ $company->email }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                {{ $company->email }}
                            </a>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Phone Number</p>
                            <a href="tel:{{ $company->phone }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                {{ $company->phone }}
                            </a>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Location</p>
                            <p class="text-gray-900 font-semibold">{{ $company->location }}</p>
                        </div>

                        @if($company->website)
                            <div>
                                <p class="text-gray-600 text-sm">Website</p>
                                <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:text-blue-700 font-semibold">
                                    {{ parse_url($company->website, PHP_URL_HOST) }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistics -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Company Statistics</h3>
                    
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <p class="text-gray-600 text-sm">Total Job Postings</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $company->jobs()->count() }}</p>
                        </div>

                        <div class="border-b pb-4">
                            <p class="text-gray-600 text-sm">Active Jobs</p>
                            <p class="text-3xl font-bold text-green-600">{{ $company->jobs()->where('status', 'active')->count() }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600 text-sm">Total Applications</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $company->jobs()->withCount('applications')->get()->sum('applications_count') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Created -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Profile Information</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">Created</p>
                            <p class="font-semibold text-gray-900">{{ $company->created_at->format('M d, Y') }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600">Last Updated</p>
                            <p class="font-semibold text-gray-900">{{ $company->updated_at->format('M d, Y') }}</p>
                        </div>

                        <div>
                            <p class="text-gray-600">Company ID</p>
                            <p class="font-semibold text-gray-900 text-xs">{{ $company->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Links</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('employer.jobs.index') }}" class="block px-4 py-2 bg-gray-100 text-gray-900 rounded hover:bg-gray-200 text-center font-medium transition">
                            My Job Postings
                        </a>
                        <a href="{{ route('employer.company.edit') }}" class="block px-4 py-2 bg-blue-100 text-blue-900 rounded hover:bg-blue-200 text-center font-medium transition">
                            Edit Company Info
                        </a>
                        <a href="{{ route('employer.dashboard') }}" class="block px-4 py-2 bg-gray-100 text-gray-900 rounded hover:bg-gray-200 text-center font-medium transition">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
