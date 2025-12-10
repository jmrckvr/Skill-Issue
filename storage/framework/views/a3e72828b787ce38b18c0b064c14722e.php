<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600 mt-2">Manage the job board, users, and content</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 10a3 3 0 11-6 0 3 3 0 016 0zM12 14c0 1 1 2 3 2s3-1 3-2-1-2-3-2-3 1-3 2zM14 9a1 1 0 100-2 1 1 0 000 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($totalUsers); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 7H7v6h6V7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Total Jobs</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($totalJobs); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 9a2 2 0 11-4 0 2 2 0 014 0zm0 0a6 6 0 1112 0 6 6 0 01-12 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Published</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($publishedJobs); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Applications</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($totalApplications); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Companies</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($totalCompanies); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Navigation -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg mb-8">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-white mb-2">Management Tools</h2>
                <p class="text-blue-100">Core admin functions to manage your platform</p>
            </div>
            <div class="bg-blue-50 px-8 py-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="<?php echo e(route('admin.users')); ?>" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-l-8 border-blue-600 hover:border-blue-700">
                    <div class="flex items-center mb-3">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-2xl font-bold text-blue-600">👥</span>
                    </div>
                    <p class="font-bold text-gray-900 text-lg">Manage Users</p>
                    <p class="text-sm text-gray-600 mt-2">View, search, and deactivate users</p>
                </a>
                <a href="<?php echo e(route('admin.jobs')); ?>" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-l-8 border-green-600 hover:border-green-700">
                    <div class="flex items-center mb-3">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-2xl font-bold text-green-600">💼</span>
                    </div>
                    <p class="font-bold text-gray-900 text-lg">Manage Jobs</p>
                    <p class="text-sm text-gray-600 mt-2">Review, restore, or delete job listings</p>
                </a>
                <a href="<?php echo e(route('admin.categories')); ?>" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-l-8 border-purple-600 hover:border-purple-700">
                    <div class="flex items-center mb-3">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 000-2H7zM4 7a1 1 0 011-1h10a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1V7zM2 13a1 1 0 011-1h14a1 1 0 011 1v3a1 1 0 01-1 1H3a1 1 0 01-1-1v-3z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-2xl font-bold text-purple-600">📁</span>
                    </div>
                    <p class="font-bold text-gray-900 text-lg">Categories</p>
                    <p class="text-sm text-gray-600 mt-2">Add, edit, or remove job categories</p>
                </a>
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-l-8 border-orange-600 hover:border-orange-700">
                    <div class="flex items-center mb-3">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-2xl font-bold text-orange-600">➕</span>
                    </div>
                    <p class="font-bold text-gray-900 text-lg">New Category</p>
                    <p class="text-sm text-gray-600 mt-2">Create a new job category</p>
                </a>
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Recent Jobs</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $recentJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-4 hover:bg-gray-50">
                            <p class="font-medium text-gray-900"><?php echo e($job->title); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($job->company->name); ?></p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs px-2 py-1 rounded-full <?php if($job->status === 'published'): ?> bg-green-100 text-green-800 <?php elseif($job->status === 'draft'): ?> bg-gray-100 text-gray-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($job->status)); ?>

                                </span>
                                <span class="text-xs text-gray-500"><?php echo e($job->created_at->format('M d, Y')); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-6 text-center text-gray-600">No jobs yet</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Recent Users</h2>
                </div>
                <div class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-4 hover:bg-gray-50">
                            <p class="font-medium text-gray-900"><?php echo e($user->name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($user->email); ?></p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs px-2 py-1 rounded-full <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800 <?php elseif($user->role === 'employer'): ?> bg-blue-100 text-blue-800 <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($user->role)); ?>

                                </span>
                                <span class="text-xs text-gray-500"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-6 text-center text-gray-600">No users yet</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>