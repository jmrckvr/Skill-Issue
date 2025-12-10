<nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-full mx-auto" style="padding-left: 40px; padding-right: 40px;">
        <div class="flex justify-between items-center h-16" style="gap: 60px;">
            <!-- Logo -->
            <a href="<?php echo e(route('home')); ?>" class="flex-shrink-0 hover:opacity-80 transition duration-300">
                <img src="/logos/skillissueiconn.png" alt="Skill Issue Logo" style="height: 50px; width: auto; background: transparent; padding: 0; margin: 0;">
            </a>

            <!-- Center Navigation Links - Spread Out -->
            <div class="flex items-center flex-1" style="gap: 80px;">
                <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-blue-600 font-medium text-sm whitespace-nowrap transition duration-300">
                    Home
                </a>
                <a href="<?php echo e(route('jobs.search')); ?>" class="text-gray-700 hover:text-blue-600 font-medium text-sm whitespace-nowrap transition duration-300">
                    Browse Jobs
                </a>
                <a href="<?php echo e(route('companies.browse')); ?>" class="text-gray-700 hover:text-blue-600 font-medium text-sm whitespace-nowrap transition duration-300">
                    Companies
                </a>
                <a href="<?php echo e(route('community.index')); ?>" class="text-gray-700 hover:text-blue-600 font-medium text-sm whitespace-nowrap transition duration-300">
                    Community
                </a>
            </div>

            <!-- Right Side - Buttons and Profile -->
            <div class="flex items-center gap-4 flex-shrink-0">
                <?php if(auth()->guard()->check()): ?>
                    <!-- User Profile Dropdown -->
                    <div class="relative inline-block">
                        <button onclick="toggleProfileDropdown(event)" class="flex items-center gap-2 px-2 py-1 rounded-full hover:bg-gray-100 transition duration-300">
                            <?php if(auth()->user()->profile_picture): ?>
                                <img src="<?php echo e(asset('storage/' . auth()->user()->profile_picture)); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="w-9 h-9 rounded-full object-cover shadow-md hover:shadow-lg transition duration-300">
                            <?php else: ?>
                                <div class="w-9 h-9 bg-gradient-to-br from-pink-400 to-pink-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md hover:shadow-lg transition duration-300">
                                    <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                                </div>
                            <?php endif; ?>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </button>

                        <div id="profileDropdown" class="hidden absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl border border-gray-200 z-50 overflow-hidden">
                            <!-- Profile Section -->
                            <div class="px-6 py-6 border-b border-gray-100 bg-gray-50">
                                <p class="text-base font-bold text-gray-900"><?php echo e(auth()->user()->name); ?></p>
                                <p class="text-sm text-gray-500 mt-1"><?php echo e(auth()->user()->email); ?></p>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-3">
                                <?php if(auth()->user()->isApplicant() || (auth()->user()->role === 'jobseeker')): ?>
                                    <a href="<?php echo e(route('applicant.dashboard')); ?>" 
                                       class="block px-6 py-3 text-gray-700 hover:bg-gray-50 transition duration-150 font-medium text-base flex items-center gap-3">
                                        <span class="text-xl">👤</span>
                                        <span>My Profile</span>
                                    </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->isEmployer()): ?>
                                    <a href="<?php echo e(route('employer.dashboard')); ?>" 
                                       class="block px-6 py-3 text-gray-700 hover:bg-gray-50 transition duration-150 font-medium text-base flex items-center gap-3">
                                        <span class="text-xl">📊</span>
                                        <span>Employer Dashboard</span>
                                    </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" 
                                       class="block px-6 py-3 text-gray-700 hover:bg-gray-50 transition duration-150 font-medium text-base flex items-center gap-3">
                                        <span class="text-xl">📊</span>
                                        <span>Admin Dashboard</span>
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('applicant.settings')); ?>" 
                                   class="block px-6 py-3 text-gray-700 hover:bg-gray-50 transition duration-150 font-medium text-base flex items-center gap-3">
                                    <span class="text-xl">⚙️</span>
                                    <span>Settings</span>
                                </a>
                            </div>

                            <!-- Logout Section -->
                            <div class="border-t border-gray-100 px-6 py-4">
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full text-left text-red-600 hover:text-red-700 font-bold text-base">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium text-sm transition duration-300 whitespace-nowrap">
                        Sign In
                    </a>
                <?php endif; ?>
                
                <!-- Employer Site Link - Always Visible -->
                <a href="<?php echo e(route('employer.landing')); ?>" class="px-4 py-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition duration-300 whitespace-nowrap">
                    Employer site
                </a>
            </div>

            </div>
        </div>
    </div>
</nav>

<script>
    function toggleProfileDropdown(event) {
        if (event) {
            event.stopPropagation();
        }
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        
        if (dropdown && !dropdown.classList.contains('hidden')) {
            const profileButton = event.target.closest('button[onclick*="toggleProfileDropdown"]');
            if (!profileButton && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });
</script>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/components/navbar.blade.php ENDPATH**/ ?>