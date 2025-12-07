<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Thread - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <x-navbar />

<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('community.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Community
                </a>
                <h1 class="text-4xl font-bold text-gray-900">Start a New Thread</h1>
                <p class="text-gray-600 mt-2">Ask a question or share something with a company</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('community.store') }}" class="bg-white rounded-lg border border-gray-200 p-8 mb-8">
                @csrf

                <!-- Company Selection -->
                <div class="mb-8">
                    <label for="company_id" class="block text-sm font-bold text-gray-900 mb-3">
                        Choose a Company
                    </label>
                    <select 
                        name="company_id" 
                        id="company_id" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900"
                        required>
                        <option value="">Select a company...</option>
                        @foreach(\App\Models\Company::orderBy('name')->get() as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thread Title -->
                <div class="mb-8">
                    <label for="title" class="block text-sm font-bold text-gray-900 mb-3">
                        Thread Title
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        placeholder="What would you like to ask or discuss?"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        maxlength="255"
                        required
                        value="{{ old('title') }}">
                    @error('title')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div class="mb-8">
                    <label for="message" class="block text-sm font-bold text-gray-900 mb-3">
                        Your Message
                    </label>
                    <textarea 
                        name="message" 
                        id="message" 
                        placeholder="Share more details about your thread..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                        rows="6"
                        maxlength="1000"
                        required>{{ old('message') }}</textarea>
                    <p class="text-xs text-gray-600 mt-2">Max 1000 characters</p>
                    @error('message')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4">
                    <button 
                        type="submit" 
                        class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                        Create Thread
                    </button>
                    <a 
                        href="{{ route('community.index') }}" 
                        class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold rounded-lg transition duration-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Tips Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="font-bold text-gray-900 mb-3">Tips for a Great Thread</h3>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li class="flex gap-3">
                        <span class="text-blue-600 font-bold">✓</span>
                        <span>Be specific and clear in your title</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-blue-600 font-bold">✓</span>
                        <span>Provide context and details in your message</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-blue-600 font-bold">✓</span>
                        <span>Ask one main question per thread</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-blue-600 font-bold">✓</span>
                        <span>Be respectful and professional</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
