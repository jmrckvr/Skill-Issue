@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">
                    @if(isset($job))
                        Edit Job Posting
                    @else
                        Create New Job Posting
                    @endif
                </h1>
                <p class="text-gray-600 mt-2">
                    @if(isset($job))
                        Update your job details to attract better candidates
                    @else
                        Fill in the details below to post a new job
                    @endif
                </p>
            </div>

            <form action="@if(isset($job)){{ route('jobs.update', $job) }}@else{{ route('jobs.store') }}@endif" method="POST" class="p-6 space-y-6">
                @csrf
                @if(isset($job))
                    @method('PATCH')
                @endif

                <!-- Company Logo Preview -->
                @if(auth()->user()->company)
                    <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border-2 border-blue-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ auth()->user()->company->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ auth()->user()->company->industry ?? 'Industry not specified' }}</p>
                                <p class="text-gray-500 text-xs mt-2">{{ auth()->user()->company->city }}, {{ auth()->user()->company->country }}</p>
                            </div>
                            @php
                                $companyLogoUrl = null;
                                if (auth()->user()->company->logo_path) {
                                    $companyLogoUrl = str_starts_with(auth()->user()->company->logo_path, 'http') ? auth()->user()->company->logo_path : asset('storage/' . auth()->user()->company->logo_path);
                                }
                            @endphp
                            @if($companyLogoUrl)
                                <img src="{{ $companyLogoUrl }}" 
                                     alt="{{ auth()->user()->company->name }}"
                                     class="w-20 h-20 rounded-lg object-cover ml-4 shadow-md" loading="lazy" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22 viewBox=%220 0 80 80%22%3E%3Crect width=%2280%22 height=%2280%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                            @else
                                <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-blue-200 to-blue-300 flex items-center justify-center ml-4">
                                    <span class="text-blue-600 font-bold text-2xl">{{ substr(auth()->user()->company->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('company.edit', auth()->user()->company) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mt-3 inline-block">
                            Update company profile & logo →
                        </a>
                    </div>
                @endif

                <!-- Job Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Job Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $job->title ?? '') }}" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="e.g., Senior Laravel Developer"
                           required>
                    @error('title')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Job Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="6" 
                              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Describe the role, responsibilities, and what you're looking for in a candidate"
                              required>{{ old('description', $job->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id', $job->category_id ?? null) == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location <span class="text-red-500">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location', $job->location ?? '') }}" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="e.g., Manila, Metro Manila"
                           required>
                    @error('location')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Type & Experience -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type <span class="text-red-500">*</span></label>
                        <select name="job_type" id="job_type" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select job type</option>
                            <option value="full-time" @if(old('job_type', $job->job_type ?? null) === 'full-time') selected @endif>Full-time</option>
                            <option value="part-time" @if(old('job_type', $job->job_type ?? null) === 'part-time') selected @endif>Part-time</option>
                            <option value="contract" @if(old('job_type', $job->job_type ?? null) === 'contract') selected @endif>Contract</option>
                            <option value="temporary" @if(old('job_type', $job->job_type ?? null) === 'temporary') selected @endif>Temporary</option>
                            <option value="freelance" @if(old('job_type', $job->job_type ?? null) === 'freelance') selected @endif>Freelance</option>
                        </select>
                        @error('job_type')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="experience_level" class="block text-sm font-medium text-gray-700">Experience Level <span class="text-red-500">*</span></label>
                        <select name="experience_level" id="experience_level" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select experience level</option>
                            <option value="entry" @if(old('experience_level', $job->experience_level ?? null) === 'entry') selected @endif>Entry Level</option>
                            <option value="mid" @if(old('experience_level', $job->experience_level ?? null) === 'mid') selected @endif>Mid Level</option>
                            <option value="senior" @if(old('experience_level', $job->experience_level ?? null) === 'senior') selected @endif>Senior Level</option>
                            <option value="executive" @if(old('experience_level', $job->experience_level ?? null) === 'executive') selected @endif>Executive</option>
                        </select>
                        @error('experience_level')
                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Salary -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <label class="block text-sm font-medium text-gray-700 mb-4">Salary Range</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="salary_min" class="block text-sm text-gray-600">Minimum Salary</label>
                            <div class="relative mt-1">
                                <span class="absolute left-3 top-2 text-gray-500">₱</span>
                                <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min', $job->salary_min ?? '') }}" 
                                       class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="50000">
                            </div>
                        </div>
                        <div>
                            <label for="salary_max" class="block text-sm text-gray-600">Maximum Salary</label>
                            <div class="relative mt-1">
                                <span class="absolute left-3 top-2 text-gray-500">₱</span>
                                <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max', $job->salary_max ?? '') }}" 
                                       class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="150000">
                            </div>
                        </div>
                        <div>
                            <label for="hide_salary" class="block text-sm text-gray-600 mt-6">
                                <input type="checkbox" name="hide_salary" id="hide_salary" value="1" @if(old('hide_salary', $job->hide_salary ?? false)) checked @endif class="mr-2">
                                Hide Salary
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements</label>
                    <textarea name="requirements" id="requirements" rows="4" 
                              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="List the key requirements and qualifications (one per line)">{{ old('requirements', $job->requirements ?? '') }}</textarea>
                    @error('requirements')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Benefits -->
                <div>
                    <label for="benefits" class="block text-sm font-medium text-gray-700">Benefits</label>
                    <textarea name="benefits" id="benefits" rows="4" 
                              class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="List the benefits offered (one per line)">{{ old('benefits', $job->benefits ?? '') }}</textarea>
                    @error('benefits')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('employer.dashboard') }}" class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        @if(isset($job))
                            Update Job
                        @else
                            Create Job as Draft
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
