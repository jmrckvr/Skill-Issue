<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition">
                    JobStreet
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Home
                    </a>
                    <a href="{{ route('jobs.search') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Browse Jobs
                    </a>
                    <a href="{{ route('jobs.search') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Companies
                    </a>
                </div>
            </div>

            <!-- Right Side Navigation -->
            <div class="hidden md:flex items-center gap-6">
                @auth
                    @if(auth()->user()->isEmployer() || auth()->user()->isAdmin())
                        <a href="{{ auth()->user()->isEmployer() ? route('employer.dashboard') : route('admin.dashboard') }}" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition">
                            {{ auth()->user()->isEmployer() ? 'Employer Dashboard' : 'Admin Panel' }}
                        </a>
                    @elseif(auth()->user()->isJobseeker())
                        <a href="{{ route('jobseeker.applications') }}" 
                           class="text-gray-700 hover:text-blue-600 font-medium transition">
                            My Applications
                        </a>
                    @endif

                    <!-- User Profile Dropdown -->
                    <div class="relative inline-block">
                        <button onclick="toggleProfileDropdown()" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </button>

                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                📝 Edit Profile
                            </a>
                            @if(auth()->user()->isJobseeker())
                                <a href="{{ route('jobseeker.applications') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                    📋 My Applications
                                </a>
                            @endif
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">
                        Sign Up
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden pb-4 border-t border-gray-100">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                Home
            </a>
            <a href="{{ route('jobs.search') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                Browse Jobs
            </a>
            <a href="{{ route('jobs.search') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                Companies
            </a>

            @auth
                <hr class="my-2">
                @if(auth()->user()->isEmployer() || auth()->user()->isAdmin())
                    <a href="{{ auth()->user()->isEmployer() ? route('employer.dashboard') : route('admin.dashboard') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        Dashboard
                    </a>
                @elseif(auth()->user()->isJobseeker())
                    <a href="{{ route('jobseeker.applications') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        My Applications
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    Edit Profile
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                        Logout
                    </button>
                </form>
            @else
                <hr class="my-2">
                <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const icon = document.getElementById('menuIcon');
        menu.classList.toggle('hidden');
        icon.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
    }

    function toggleProfileDropdown() {
        document.getElementById('profileDropdown').classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        const button = event.target.closest('button');
        if (dropdown && !dropdown.contains(event.target) && button?.onclick !== toggleProfileDropdown) {
            dropdown.classList.add('hidden');
        }
    });
</script>
