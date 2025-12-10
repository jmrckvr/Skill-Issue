<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($job) ? 'Edit' : 'Create' }} Job - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-12">
            <a href="{{ route('employer.jobs.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold mb-4 inline-block">← Back to Job Listings</a>
            <h1 class="text-4xl font-bold text-gray-900">{{ isset($job) ? '✎ Edit Job Listing' : '➕ Create New Job Listing' }}</h1>
            <p class="text-gray-600 mt-3">{{ isset($job) ? 'Update your job posting details to attract the right candidates' : 'Fill in the details below to post a job and start receiving applications' }}</p>
        </div>

        <!-- Form -->
        <form action="{{ isset($job) ? route('employer.jobs.update', $job) : route('employer.jobs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($job))
                @method('PUT')
            @endif

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8 border-l-4 border-blue-600">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white text-sm">1</span>
                        Basic Information
                    </h2>
                    <p class="text-gray-600 mt-2">Essential job posting information</p>
                </div>

                <div class="space-y-6">
                    <!-- Job Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $job->title ?? '') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                            placeholder="e.g., Senior Software Engineer">
                        <p class="text-gray-500 text-xs mt-1">Be specific and descriptive about the position</p>
                        @error('title')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location & Job Type Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location <span class="text-red-500">*</span></label>
                            <input type="text" id="location" name="location" value="{{ old('location', $job->location ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror"
                                placeholder="e.g., Manila, Philippines">
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Type -->
                        <div>
                            <label for="job_type" class="block text-sm font-semibold text-gray-700 mb-2">Job Type <span class="text-red-500">*</span></label>
                            <select id="job_type" name="job_type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('job_type') border-red-500 @enderror">
                                <option value="">Select Job Type</option>
                                <option value="full-time" {{ old('job_type', $job->job_type ?? '') === 'full-time' ? 'selected' : '' }}>🏢 Full Time</option>
                                <option value="part-time" {{ old('job_type', $job->job_type ?? '') === 'part-time' ? 'selected' : '' }}>⏰ Part Time</option>
                                <option value="contract" {{ old('job_type', $job->job_type ?? '') === 'contract' ? 'selected' : '' }}>📋 Contract</option>
                                <option value="temporary" {{ old('job_type', $job->job_type ?? '') === 'temporary' ? 'selected' : '' }}>📅 Temporary</option>
                                <option value="freelance" {{ old('job_type', $job->job_type ?? '') === 'freelance' ? 'selected' : '' }}>💻 Freelance</option>
                            </select>
                            @error('job_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Experience Level & Category Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Experience Level -->
                        <div>
                            <label for="experience_level" class="block text-sm font-semibold text-gray-700 mb-2">Experience Level <span class="text-red-500">*</span></label>
                            <select id="experience_level" name="experience_level" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('experience_level') border-red-500 @enderror">
                                <option value="">Select Experience Level</option>
                                <option value="entry" {{ old('experience_level', $job->experience_level ?? '') === 'entry' ? 'selected' : '' }}>📍 Entry Level</option>
                                <option value="mid" {{ old('experience_level', $job->experience_level ?? '') === 'mid' ? 'selected' : '' }}>⭐ Mid Level</option>
                                <option value="senior" {{ old('experience_level', $job->experience_level ?? '') === 'senior' ? 'selected' : '' }}>🌟 Senior Level</option>
                                <option value="executive" {{ old('experience_level', $job->experience_level ?? '') === 'executive' ? 'selected' : '' }}>👔 Executive</option>
                            </select>
                            @error('experience_level')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $job->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Job Details -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8 border-l-4 border-green-600">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white text-sm">2</span>
                        Job Details
                    </h2>
                    <p class="text-gray-600 mt-2">Describe the role and what you're looking for</p>
                </div>

                <div class="space-y-6">
                    <!-- Job Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Job Description <span class="text-red-500">*</span></label>
                        <textarea id="description" name="description" rows="7" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                            placeholder="Describe the role, responsibilities, and what you're looking for...">{{ old('description', $job->description ?? '') }}</textarea>
                        <p class="text-gray-500 text-xs mt-1">Include key responsibilities, reporting structure, and day-to-day activities</p>
                        @error('description')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Requirements -->
                    <div>
                        <label for="requirements" class="block text-sm font-semibold text-gray-700 mb-2">Requirements <span class="text-gray-500">(Optional)</span></label>
                        <textarea id="requirements" name="requirements" rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('requirements') border-red-500 @enderror"
                            placeholder="List key requirements (e.g., Bachelor's degree, 5+ years experience, specific skills)...">{{ old('requirements', $job->requirements ?? '') }}</textarea>
                        <p class="text-gray-500 text-xs mt-1">Be specific about education, experience, and skills required</p>
                        @error('requirements')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Benefits -->
                    <div>
                        <label for="benefits" class="block text-sm font-semibold text-gray-700 mb-2">Benefits <span class="text-gray-500">(Optional)</span></label>
                        <textarea id="benefits" name="benefits" rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('benefits') border-red-500 @enderror"
                            placeholder="List benefits offered (e.g., Health insurance, Remote work, Stock options, Professional development)...">{{ old('benefits', $job->benefits ?? '') }}</textarea>
                        <p class="text-gray-500 text-xs mt-1">Highlight what makes your job offer attractive</p>
                        @error('benefits')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Salary & Media -->
            <div class="bg-white rounded-lg shadow-md p-8 border-l-4 border-purple-600">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-600 text-white text-sm">3</span>
                        Salary & Media
                    </h2>
                    <p class="text-gray-600 mt-2">Compensation and visual branding</p>
                </div>

                <div class="space-y-6">
                    <!-- Salary Information Row -->
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-lg border border-purple-200">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <span>💰</span> Salary Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Salary Min -->
                            <div>
                                <label for="salary_min" class="block text-sm font-semibold text-gray-700 mb-2">Minimum Salary <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-600 font-semibold">₱</span>
                                    <input type="number" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min ?? '') }}" required min="0" step="1000"
                                        class="w-full pl-8 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('salary_min') border-red-500 @enderror"
                                        placeholder="50000">
                                </div>
                                @error('salary_min')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Salary Max -->
                            <div>
                                <label for="salary_max" class="block text-sm font-semibold text-gray-700 mb-2">Maximum Salary <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-600 font-semibold">₱</span>
                                    <input type="number" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max ?? '') }}" required min="0" step="1000"
                                        class="w-full pl-8 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('salary_max') border-red-500 @enderror"
                                        placeholder="100000">
                                </div>
                                @error('salary_max')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div>
                                <label for="currency" class="block text-sm font-semibold text-gray-700 mb-2">Currency <span class="text-red-500">*</span></label>
                                <select id="currency" name="currency" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('currency') border-red-500 @enderror">
                                    <option value="PHP" {{ old('currency', $job->currency ?? 'PHP') === 'PHP' ? 'selected' : '' }}>PHP - Philippine Peso</option>
                                    <option value="USD" {{ old('currency', $job->currency ?? '') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                    <option value="EUR" {{ old('currency', $job->currency ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                </select>
                                @error('currency')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hide Salary -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="hide_salary" value="1" {{ old('hide_salary', $job->hide_salary ?? false) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-gray-300 focus:ring-2 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Hide salary information from job listing</span>
                            </label>
                        </div>
                    </div>

                    <!-- Job Logo -->
                    <div>
                        <label for="logo" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <span>🖼️</span> Job Logo <span class="text-gray-500 font-normal">(Optional)</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Logo Preview -->
                            @if(isset($job) && $job->logo)
                                @php
                                    $logoUrl = null;
                                    if ($job->logo) {
                                        if (filter_var($job->logo, FILTER_VALIDATE_URL)) {
                                            $logoUrl = $job->logo;
                                        } elseif (str_starts_with($job->logo, 'logos/') || file_exists(public_path($job->logo))) {
                                            $logoUrl = asset($job->logo);
                                        } else {
                                            $logoUrl = asset('storage/' . $job->logo);
                                        }
                                    }
                                @endphp
                                <div class="bg-gray-50 p-4 rounded-lg border-2 border-dashed border-gray-300">
                                    <p class="text-xs text-gray-600 font-semibold mb-2 uppercase">Current Logo</p>
                                    <img src="{{ $logoUrl }}" alt="Job Logo" class="w-full h-32 object-cover rounded">
                                </div>
                            @endif
                            
                            <!-- Logo Upload -->
                            <div class="md:col-span-2">
                                <div class="bg-blue-50 p-6 rounded-lg border-2 border-dashed border-blue-300">
                                    <input type="file" id="logo" name="logo" accept="image/*" class="w-full">
                                    <p class="text-gray-600 text-sm mt-3">
                                        <strong>Supported formats:</strong> PNG, JPG, GIF (max 2MB)
                                    </p>
                                    <p class="text-gray-500 text-xs mt-2">Click to select a logo or drag and drop</p>
                                </div>
                                @error('logo')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-8 border-t border-gray-200">
                <a href="{{ route('employer.jobs.index') }}" class="px-8 py-3 text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 font-semibold transition">
                    ← Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold transition shadow-md">
                    {{ isset($job) ? '✓ Update Job Listing' : '➕ Post Job Listing' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('File selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
