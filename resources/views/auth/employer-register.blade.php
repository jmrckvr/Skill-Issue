<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Registration - JobStreet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
        <div class="w-full max-w-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <div class="text-3xl font-bold text-blue-600">JobStreet</div>
                    <p class="text-gray-600 text-sm mt-1">Employer Registration</p>
                </a>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Register Your Company</h2>
                
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-800 text-sm font-semibold mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-700 text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register-employer') }}" class="space-y-6">
                    @csrf

                    <!-- Section: Personal Information -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Information</h3>
                        
                        <!-- Full Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                placeholder="John Doe">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                placeholder="you@company.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section: Company Information -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
                        
                        <!-- Company Name -->
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-2">Company Name</label>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_name') border-red-500 @enderror"
                                placeholder="Acme Corporation">
                            @error('company_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Email -->
                        <div class="mb-4">
                            <label for="company_email" class="block text-sm font-semibold text-gray-700 mb-2">Company Email</label>
                            <input type="email" id="company_email" name="company_email" value="{{ old('company_email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_email') border-red-500 @enderror"
                                placeholder="hr@company.com">
                            @error('company_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Phone -->
                        <div class="mb-4">
                            <label for="company_phone" class="block text-sm font-semibold text-gray-700 mb-2">Company Phone</label>
                            <input type="tel" id="company_phone" name="company_phone" value="{{ old('company_phone') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_phone') border-red-500 @enderror"
                                placeholder="+1 (555) 123-4567">
                            @error('company_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Website -->
                        <div class="mb-4">
                            <label for="company_website" class="block text-sm font-semibold text-gray-700 mb-2">Company Website <span class="text-gray-500">(Optional)</span></label>
                            <input type="url" id="company_website" name="company_website" value="{{ old('company_website') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_website') border-red-500 @enderror"
                                placeholder="https://www.company.com">
                            @error('company_website')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Description -->
                        <div class="mb-4">
                            <label for="company_description" class="block text-sm font-semibold text-gray-700 mb-2">Company Description <span class="text-gray-500">(Optional)</span></label>
                            <textarea id="company_description" name="company_description" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_description') border-red-500 @enderror"
                                placeholder="Tell us about your company...">{{ old('company_description') }}</textarea>
                            @error('company_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Industry -->
                        <div class="mb-4">
                            <label for="company_industry" class="block text-sm font-semibold text-gray-700 mb-2">Industry <span class="text-gray-500">(Optional)</span></label>
                            <input type="text" id="company_industry" name="company_industry" value="{{ old('company_industry') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_industry') border-red-500 @enderror"
                                placeholder="e.g., Technology, Finance, Healthcare">
                            @error('company_industry')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company City -->
                        <div class="mb-4">
                            <label for="company_city" class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                            <input type="text" id="company_city" name="company_city" value="{{ old('company_city') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_city') border-red-500 @enderror"
                                placeholder="Manila">
                            @error('company_city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Country -->
                        <div>
                            <label for="company_country" class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                            <input type="text" id="company_country" name="company_country" value="{{ old('company_country') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_country') border-red-500 @enderror"
                                placeholder="Philippines">
                            @error('company_country')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section: Password -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Security</h3>
                        
                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                placeholder="••••••••">
                            <p class="text-gray-600 text-xs mt-2">Minimum 8 characters. Include uppercase, lowercase, numbers, and symbols.</p>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                        Create Employer Account
                    </button>

                    <!-- Sign In Link -->
                    <p class="text-center text-gray-600 text-sm">
                        Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Sign in here</a>
                    </p>
                </form>
            </div>

            <!-- Features -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-xl">📋</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Post Jobs Instantly</h3>
                    <p class="text-gray-600 text-sm">Create and publish job listings in minutes</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-xl">👥</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Find Top Talent</h3>
                    <p class="text-gray-600 text-sm">Access a pool of qualified job candidates</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <span class="text-xl">📊</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Track Applications</h3>
                    <p class="text-gray-600 text-sm">Manage and review all job applications</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
