<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Skill Issue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-image: url('/logos/bg1.jpg'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; margin: 0; position: relative;">
    <div class="absolute inset-0 bg-black/40 z-0"></div>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <div class="text-3xl font-bold text-black">Skill Issue</div>
                    <p class="text-black text-sm mt-1">Find your dream job today</p>
                </a>
            </div>

            <!-- Session Status -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 text-sm font-semibold mb-2">Error logging in</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-red-700 text-sm">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Welcome Back</h2>
                
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                            required
                            autofocus
                            autocomplete="email"
                        />
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                            required
                            autocomplete="current-password"
                        />
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="remember_me"
                            name="remember"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer"
                        />
                        <label for="remember_me" class="ml-2 text-sm text-gray-700 cursor-pointer">
                            Keep me signed in
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        style="display: block; width: 100%; background-color: #2563eb; color: white; padding: 12px 16px; border-radius: 8px; font-weight: bold; font-size: 16px; border: none; cursor: pointer; margin-top: 16px;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'"
                        onmouseout="this.style.backgroundColor='#2563eb'"
                    >
                        Sign In
                    </button>

                    <!-- Google Sign-In Button -->
                    <a href="{{ route('auth.google') }}" 
                       style="display: flex; align-items: center; justify-content: center; width: 100%; background-color: white; color: #374151; padding: 12px 16px; border-radius: 8px; font-weight: 500; font-size: 16px; border: 1px solid #e5e7eb; cursor: pointer; margin-top: 12px; text-decoration: none; transition: all 0.3s ease;"
                       onmouseover="this.style.backgroundColor='#f9fafb'; this.style.borderColor='#d1d5db';"
                       onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#e5e7eb';"
                    >
                        <svg style="width: 20px; height: 20px; margin-right: 10px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Sign in with Google
                    </a>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-sm text-gray-500">or</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Forgot Password Link -->
                <p class="text-center text-sm mb-6">
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Forgot your password?
                    </a>
                </p>
            </div>

            <!-- Sign Up Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-700">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Create one now
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200 text-center text-xs text-gray-500">
                <p>By signing in, you agree to our <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a></p>
            </div>
        </div>
    </div>
</body>
</html>
