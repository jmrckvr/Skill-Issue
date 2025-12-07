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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ isset($job) ? 'Edit Job Listing' : 'Create New Job Listing' }}</h1>
            <p class="text-gray-600 mt-2">{{ isset($job) ? 'Update your job posting details' : 'Fill in the details below to post a new job' }}</p>
        </div>

        <!-- Form -->
        <form action="{{ isset($job) ? route('employer.jobs.update', $job) : route('employer.jobs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-8 space-y-6">
            @csrf
            @if(isset($job))
                @method('PUT')
            @endif

            <!-- Job Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Job Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $job->title ?? '') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                    placeholder="e.g., Senior Software Engineer">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Job Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Job Description <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="6" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                    placeholder="Describe the role, responsibilities, and what you're looking for...">{{ old('description', $job->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid 2 Columns -->
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
                        <option value="full-time" {{ old('job_type', $job->job_type ?? '') === 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ old('job_type', $job->job_type ?? '') === 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contract" {{ old('job_type', $job->job_type ?? '') === 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="temporary" {{ old('job_type', $job->job_type ?? '') === 'temporary' ? 'selected' : '' }}>Temporary</option>
                        <option value="freelance" {{ old('job_type', $job->job_type ?? '') === 'freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                    @error('job_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Grid 2 Columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Experience Level -->
                <div>
                    <label for="experience_level" class="block text-sm font-semibold text-gray-700 mb-2">Experience Level <span class="text-red-500">*</span></label>
                    <select id="experience_level" name="experience_level" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('experience_level') border-red-500 @enderror">
                        <option value="">Select Experience Level</option>
                        <option value="entry" {{ old('experience_level', $job->experience_level ?? '') === 'entry' ? 'selected' : '' }}>Entry Level</option>
                        <option value="mid" {{ old('experience_level', $job->experience_level ?? '') === 'mid' ? 'selected' : '' }}>Mid Level</option>
                        <option value="senior" {{ old('experience_level', $job->experience_level ?? '') === 'senior' ? 'selected' : '' }}>Senior Level</option>
                        <option value="executive" {{ old('experience_level', $job->experience_level ?? '') === 'executive' ? 'selected' : '' }}>Executive</option>
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

            <!-- Salary Section -->
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                <h3 class="font-semibold text-gray-900 mb-4">Salary Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Salary Min -->
                    <div>
                        <label for="salary_min" class="block text-sm font-semibold text-gray-700 mb-2">Minimum Salary <span class="text-red-500">*</span></label>
                        <input type="number" id="salary_min" name="salary_min" value="{{ old('salary_min', $job->salary_min ?? '') }}" required min="0" step="1000"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('salary_min') border-red-500 @enderror"
                            placeholder="50000">
                        @error('salary_min')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Salary Max -->
                    <div>
                        <label for="salary_max" class="block text-sm font-semibold text-gray-700 mb-2">Maximum Salary <span class="text-red-500">*</span></label>
                        <input type="number" id="salary_max" name="salary_max" value="{{ old('salary_max', $job->salary_max ?? '') }}" required min="0" step="1000"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('salary_max') border-red-500 @enderror"
                            placeholder="100000">
                        @error('salary_max')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Currency -->
                    <div>
                        <label for="currency" class="block text-sm font-semibold text-gray-700 mb-2">Currency <span class="text-red-500">*</span></label>
                        <select id="currency" name="currency" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('currency') border-red-500 @enderror">
                            <option value="PHP" {{ old('currency', $job->currency ?? 'PHP') === 'PHP' ? 'selected' : '' }}>PHP</option>
                            <option value="USD" {{ old('currency', $job->currency ?? '') === 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ old('currency', $job->currency ?? '') === 'EUR' ? 'selected' : '' }}>EUR</option>
                        </select>
                        @error('currency')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Hide Salary -->
                <div class="mt-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="hide_salary" value="1" {{ old('hide_salary', $job->hide_salary ?? false) ? 'checked' : '' }}
                            class="rounded border-gray-300 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Hide salary from job listing</span>
                    </label>
                </div>
            </div>

            <!-- Requirements -->
            <div>
                <label for="logo" class="block text-sm font-semibold text-gray-700 mb-2">Job Logo <span class="text-gray-500">(Optional)</span></label>
                <div class="mt-2 flex items-center gap-4">
                    @if(isset($job) && $job->logo)
                        @php
                            $logoUrl = str_starts_with($job->logo, 'http') ? $job->logo : asset('storage/' . $job->logo);
                        @endphp
                        <img src="{{ $logoUrl }}" alt="Job Logo" class="w-20 h-20 object-cover rounded" loading="lazy" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22 viewBox=%220 0 80 80%22%3E%3Crect width=%2280%22 height=%2280%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                    @endif
                    <input type="file" id="logo" name="logo" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('logo') border-red-500 @enderror">
                </div>
                <p class="text-gray-500 text-sm mt-1">Upload a logo for this job listing (PNG, JPG, GIF - max 2MB)</p>
                @error('logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Requirements -->
                <label for="requirements" class="block text-sm font-semibold text-gray-700 mb-2">Requirements <span class="text-gray-500">(Optional)</span></label>
                <textarea id="requirements" name="requirements" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('requirements') border-red-500 @enderror"
                    placeholder="List key requirements (e.g., Bachelor's degree, 5+ years experience)...">{{ old('requirements', $job->requirements ?? '') }}</textarea>
                @error('requirements')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Benefits -->
            <div>
                <label for="benefits" class="block text-sm font-semibold text-gray-700 mb-2">Benefits <span class="text-gray-500">(Optional)</span></label>
                <textarea id="benefits" name="benefits" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('benefits') border-red-500 @enderror"
                    placeholder="List benefits offered (e.g., Health insurance, Remote work, Stock options)...">{{ old('benefits', $job->benefits ?? '') }}</textarea>
                @error('benefits')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('employer.jobs.index') }}" class="px-6 py-3 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                    {{ isset($job) ? 'Update Job Listing' : 'Post Job Listing' }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
