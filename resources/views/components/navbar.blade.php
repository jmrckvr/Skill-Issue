<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    JobStreet
                </a>
            </div>

            <!-- Search Bar (Mobile hidden) -->
            <div class="hidden md:flex flex-1 mx-8">
                <form action="{{ route('jobs.search') }}" method="GET" class="w-full max-w-md">
                    <div class="flex">
                        <input type="text" name="keyword" placeholder="Search jobs..." 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            value="{{ request('keyword', '') }}">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-r-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center space-x-1">
                @auth
                    @if(auth()->user()->isEmployer())
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                            Post a Job
                        </a>
                    @endif
                    <div class="relative inline-block text-left">
                        <button onclick="toggleDropdown()" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                            {{ auth()->user()->name }}
                        </button>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                        Sign Up
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <form action="{{ route('jobs.search') }}" method="GET" class="mb-4">
                <input type="text" name="keyword" placeholder="Search jobs..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    value="{{ request('keyword', '') }}">
            </form>
            @auth
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                    Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    }
</script>
