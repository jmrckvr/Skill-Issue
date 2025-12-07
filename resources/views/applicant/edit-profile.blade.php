<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <x-navbar />

    <div class="min-h-screen bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto">
                <!-- Header -->
                <div class="mb-8">
                    <a href="{{ route('applicant.dashboard') }}" class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                    <h1 class="text-4xl font-bold text-gray-900">Edit Profile</h1>
                    <p class="text-gray-600 mt-2">Update your profile information</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('applicant.update-profile') }}" class="bg-white rounded-lg border border-gray-200 p-8">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-bold text-gray-900 mb-2">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-2">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            required>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div class="mb-6">
                        <label for="contact_number" class="block text-sm font-bold text-gray-900 mb-2">
                            Contact Number
                        </label>
                        <input 
                            type="text" 
                            name="contact_number" 
                            id="contact_number" 
                            value="{{ old('contact_number', $user->contact_number) }}"
                            placeholder="+1 (555) 123-4567"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('contact_number')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <label for="location" class="block text-sm font-bold text-gray-900 mb-2">
                            Location
                        </label>
                        <input 
                            type="text" 
                            name="location" 
                            id="location" 
                            value="{{ old('location', $user->location) }}"
                            placeholder="City, Country"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('location')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Skills -->
                    <div class="mb-6">
                        <label for="skills" class="block text-sm font-bold text-gray-900 mb-2">
                            Skills
                        </label>
                        <textarea 
                            name="skills" 
                            id="skills" 
                            placeholder="e.g., PHP, Laravel, Vue.js, MySQL"
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('skills', $user->skills) }}</textarea>
                        <p class="text-xs text-gray-600 mt-1">Separate skills with commas</p>
                        @error('skills')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div class="mb-6">
                        <label for="bio" class="block text-sm font-bold text-gray-900 mb-2">
                            About / Bio
                        </label>
                        <textarea 
                            name="bio" 
                            id="bio" 
                            placeholder="Tell employers about yourself..."
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Social Links Section -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Social Links (Optional)</h3>

                        <!-- LinkedIn URL -->
                        <div class="mb-6">
                            <label for="linkedin_url" class="block text-sm font-bold text-gray-900 mb-2">
                                LinkedIn URL
                            </label>
                            <input 
                                type="url" 
                                name="linkedin_url" 
                                id="linkedin_url" 
                                value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                placeholder="https://linkedin.com/in/yourprofile"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('linkedin_url')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- GitHub URL -->
                        <div class="mb-6">
                            <label for="github_url" class="block text-sm font-bold text-gray-900 mb-2">
                                GitHub URL
                            </label>
                            <input 
                                type="url" 
                                name="github_url" 
                                id="github_url" 
                                value="{{ old('github_url', $user->github_url) }}"
                                placeholder="https://github.com/yourprofile"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('github_url')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Portfolio URL -->
                        <div class="mb-6">
                            <label for="portfolio_url" class="block text-sm font-bold text-gray-900 mb-2">
                                Portfolio URL
                            </label>
                            <input 
                                type="url" 
                                name="portfolio_url" 
                                id="portfolio_url" 
                                value="{{ old('portfolio_url', $user->portfolio_url) }}"
                                placeholder="https://yourportfolio.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('portfolio_url')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-4">
                        <button 
                            type="submit" 
                            class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                            Save Changes
                        </button>
                        <a 
                            href="{{ route('applicant.dashboard') }}" 
                            class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold rounded-lg transition duration-200 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
