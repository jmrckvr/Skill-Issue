<!-- Applicant Dashboard Sidebar Navigation -->
<div class="w-full sm:w-64 bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
    <!-- Profile Section -->
    <div class="mb-8 pb-8 border-b border-gray-200">
        <div class="flex items-center gap-4 mb-4">
            @if($user->profile_picture && str_starts_with($user->profile_picture, 'profile_pictures/'))
                <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                     alt="{{ $user->name }}"
                     class="w-12 h-12 rounded-full object-cover border-2 border-blue-600">
            @else
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-white font-bold border-2 border-pink-500">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 truncate">{{ $user->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
            </div>
        </div>
        <button onclick="toggleProfileMenu()" class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-100 transition text-sm font-medium text-gray-700">
            ⚙️ Account
        </button>
        <div id="profileMenu" class="hidden mt-2 space-y-1">
            <a href="{{ route('applicant.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-50 transition text-sm text-gray-600 hover:text-blue-600 border-l-2 border-transparent hover:border-blue-600">
                View Profile
            </a>
            <a href="{{ route('applicant.edit-profile') }}" class="block px-3 py-2 rounded-lg hover:bg-blue-50 transition text-sm text-gray-600 hover:text-blue-600 border-l-2 border-transparent hover:border-blue-600">
                Edit Profile
            </a>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="space-y-2">
        <!-- Profile -->
        <a href="{{ route('applicant.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition font-medium {{ request()->routeIs('applicant.dashboard') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
            👤 <span>Profile</span>
        </a>

        <!-- Saved Searches -->
        <a href="{{ route('applicant.saved-searches') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition font-medium {{ request()->routeIs('applicant.saved-searches') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
            💾 <span>Saved Searches</span>
        </a>

        <!-- Saved Jobs -->
        <a href="{{ route('applicant.saved-jobs') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition font-medium {{ request()->routeIs('applicant.saved-jobs') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
            ⭐ <span>Saved Jobs</span>
        </a>

        <!-- Job Applications -->
        <a href="{{ route('applicant.job-applications') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition font-medium {{ request()->routeIs('applicant.job-applications') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
            📋 <span>Job Applications</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('applicant.settings') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition font-medium {{ request()->routeIs('applicant.settings') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
            ⚙️ <span>Settings</span>
        </a>
    </nav>

    <!-- Sign Out Button -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full px-4 py-3 text-left rounded-lg transition font-medium text-red-600 hover:bg-red-50 border-l-4 border-transparent hover:border-red-600">
                🚪 Sign out
            </button>
        </form>
    </div>
</div>

<script>
    function toggleProfileMenu() {
        const menu = document.getElementById('profileMenu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('profileMenu');
        const button = event.target.closest('button[onclick*="toggleProfileMenu"]');
        
        if (menu && !menu.classList.contains('hidden') && !button && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
</script>
