<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Companies - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-white">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 text-white py-16 md:py-24 overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-500 rounded-full opacity-15 blur-3xl"></div>
        <div class="absolute -bottom-10 left-10 w-48 h-48 bg-blue-500 rounded-full opacity-10 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Find the right company for you</h1>
            <p class="text-blue-100 text-lg md:text-xl max-w-2xl">Everything you need to know about a company, all in one place</p>

            <!-- Search Bar -->
            <form action="<?php echo e(route('companies.browse')); ?>" method="GET" class="mt-12 max-w-3xl">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <input type="text" name="keyword" placeholder="Search by company name" 
                            class="w-full px-5 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 font-medium"
                            value="<?php echo e(request('keyword', '')); ?>">
                    </div>
                    <div class="flex-1">
                        <input type="text" name="location" placeholder="City or location" 
                            class="w-full px-5 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 font-medium"
                            value="<?php echo e(request('location', '')); ?>">
                    </div>
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-3 rounded-lg font-bold transition duration-300 transform hover:scale-105 active:scale-95 whitespace-nowrap">
                        Search
                    </button>
                </div>
            </form>

            <?php if(request()->anyFilled(['keyword', 'location'])): ?>
                <div class="mt-4">
                    <a href="<?php echo e(route('companies.browse')); ?>" class="text-blue-200 hover:text-white font-medium text-sm transition duration-300 inline-flex items-center gap-1">
                        Clear filters
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="py-16 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Title -->
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Explore companies</h2>
                <p class="text-gray-600 text-lg">Learn about new jobs, reviews, company culture, perks and benefits.</p>
            </div>

            <?php if($companies->count() > 0): ?>
                <!-- Companies Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('jobs.search', ['company' => $company->id])); ?>" class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer block" style="text-decoration: none; color: inherit;">
                            <!-- Card Header with Logo -->
                            <div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 border-b border-gray-200">
                                <div class="flex justify-center mb-4 h-20">
                                    <?php
                                        $logoUrl = null;
                                        if ($company->logo_path) {
                                            if (filter_var($company->logo_path, FILTER_VALIDATE_URL)) {
                                                $logoUrl = $company->logo_path;
                                            } elseif (str_starts_with($company->logo_path, 'logos/') || file_exists(public_path($company->logo_path))) {
                                                $logoUrl = asset($company->logo_path);
                                            } else {
                                                $logoUrl = asset('storage/' . $company->logo_path);
                                            }
                                        }
                                    ?>
                                    <div class="logo-container flex justify-center items-center h-20 w-20 mx-auto">
                                        <?php if($logoUrl): ?>
                                            <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($company->name); ?>" class="max-h-20 max-w-full object-contain company-logo" data-company-id="<?php echo e($company->id); ?>" loading="lazy" decoding="async">
                                        <?php else: ?>
                                            <div class="h-20 w-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center text-white text-2xl font-bold">
                                                <?php echo e(substr($company->name, 0, 1)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6">
                                <!-- Company Name -->
                                <h3 class="text-lg font-bold text-gray-900 text-center mb-3 group-hover:text-blue-600 transition">
                                    <?php echo e($company->name); ?>

                                </h3>

                                <!-- Rating and Reviews -->
                                <div class="flex items-center justify-center gap-3 mb-4 text-center">
                                    <div class="flex items-center">
                                        <?php for($i = 0; $i < 5; $i++): ?>
                                            <svg class="w-4 h-4 <?php echo e($i < 4 ? 'text-yellow-400' : 'text-gray-300'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">4.2</span>
                                </div>

                                <!-- Reviews Count -->
                                <p class="text-sm text-gray-600 text-center mb-4">66 Reviews</p>

                                <!-- Jobs Count -->
                                <div class="pt-4 border-t border-gray-200">
                                    <span class="inline-block px-4 py-2 bg-blue-50 text-blue-600 font-semibold text-sm rounded-lg group-hover:bg-blue-100 transition w-full text-center">
                                        <?php echo e($company->jobs_count); ?> <?php echo e($company->jobs_count === 1 ? 'Job' : 'Jobs'); ?>

                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Features Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-16 border-t border-gray-200 mt-12">
                    <div class="text-center">
                        <div class="flex justify-center mb-4">
                            <svg class="w-16 h-16 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Culture and values</h3>
                        <p class="text-gray-600">Find out about the company culture</p>
                    </div>

                    <div class="text-center">
                        <div class="flex justify-center mb-4">
                            <svg class="w-16 h-16 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.161c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.368-2.447a1 1 0 00-1.175 0l-3.368 2.447c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.049 8.384c-.783-.57-.38-1.81.588-1.81h4.161a1 1 0 00.95-.69l1.286-3.957z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Ratings and reviews</h3>
                        <p class="text-gray-600">Read reviews from employees</p>
                    </div>

                    <div class="text-center">
                        <div class="flex justify-center mb-4">
                            <svg class="w-16 h-16 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Perks and benefits</h3>
                        <p class="text-gray-600">Find perks that matter to you</p>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    <?php echo e($companies->links()); ?>

                </div>
            <?php else: ?>
                <!-- No Results State -->
                <div class="text-center py-16">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No companies found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search criteria</p>
                    <a href="<?php echo e(route('companies.browse')); ?>" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        View all companies
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        // Handle image load failures for company logos
        document.querySelectorAll('.company-logo').forEach(img => {
            img.addEventListener('error', function() {
                const container = this.closest('.logo-container');
                const companyName = this.alt;
                const initials = companyName.charAt(0).toUpperCase();
                
                container.innerHTML = `
                    <div class="h-20 w-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center text-white text-2xl font-bold">
                        ${initials}
                    </div>
                `;
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/companies/browse.blade.php ENDPATH**/ ?>