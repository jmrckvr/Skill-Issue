<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Employer Dashboard</h1>
                <p class="text-gray-600 mt-2">Manage your company and job postings</p>
            </div>
            <a href="<?php echo e(route('employer.jobs.create')); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Post New Job
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Active Jobs -->
            <a href="<?php echo e(route('employer.jobs.index')); ?>" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 7H7v6h6V7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Active Jobs</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($activeJobs); ?></p>
                    </div>
                </div>
            </a>

            <!-- Total Applications -->
            <a href="<?php echo e(route('employer.jobs.index')); ?>" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Total Applications</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($totalApplications); ?></p>
                    </div>
                </div>
            </a>

            <!-- Pending Reviews -->
            <a href="<?php echo e(route('employer.jobs.index')); ?>" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 11a3 3 0 110-6 3 3 0 010 6zm0 0a7 7 0 100 14 7 7 0 000-14z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Pending Reviews</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($pendingApplications); ?></p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Company Profile Section -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Company Information</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Company Name</label>
                        <p class="mt-1 text-gray-900"><?php echo e(auth()->user()->company->name ?? 'Not set'); ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-gray-900"><?php echo e(auth()->user()->company->email ?? 'Not set'); ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Location</label>
                        <p class="mt-1 text-gray-900"><?php echo e(auth()->user()->company->city); ?>, <?php echo e(auth()->user()->company->country); ?></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Employees</label>
                        <p class="mt-1 text-gray-900"><?php echo e(auth()->user()->company->employee_count); ?></p>
                    </div>
                </div>
                <div class="mt-6">
                    <label class="text-sm font-medium text-gray-700">About Company</label>
                    <p class="mt-1 text-gray-700"><?php echo e(auth()->user()->company->description); ?></p>
                </div>
                <a href="<?php echo e(route('company.edit', auth()->user()->company)); ?>" class="mt-6 inline-block text-blue-600 hover:text-blue-700 font-medium">
                    Edit Company Profile
                </a>
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Your Job Postings</h2>
            </div>

            <?php if($recentJobs->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Job Title</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Applications</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Posted</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <a href="<?php echo e(route('employer.jobs.show', $job)); ?>" class="text-blue-600 hover:text-blue-700 font-medium">
                                            <?php echo e($job->title); ?>

                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($job->status === 'published'): ?>
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Published</span>
                                        <?php elseif($job->status === 'draft'): ?>
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">Draft</span>
                                        <?php elseif($job->status === 'closed'): ?>
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Closed</span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium"><?php echo e(ucfirst($job->status)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900 font-medium">
                                        <?php echo e($job->application_count); ?>

                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-sm">
                                        <?php if($job->published_at): ?>
                                            <?php echo e($job->published_at->format('M d, Y')); ?>

                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <?php if($job->status === 'draft'): ?>
                                                <form action="<?php echo e(route('employer.jobs.publish', $job)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="text-green-600 hover:text-green-700 font-medium text-sm">
                                                        Publish
                                                    </button>
                                                </form>
                                            <?php elseif($job->status === 'published'): ?>
                                                <a href="<?php echo e(route('employer.jobs.edit', $job)); ?>" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                                    Edit
                                                </a>
                                                <form action="<?php echo e(route('employer.jobs.close', $job)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-700 font-medium text-sm">
                                                        Close
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('employer.jobs.applicants', $job)); ?>" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                                View Applicants
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($recentJobs->links()); ?>

                </div>
            <?php else: ?>
                <div class="p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No jobs posted yet</h3>
                    <p class="mt-1 text-gray-600">Get started by posting your first job.</p>
                    <a href="<?php echo e(route('employer.jobs.create')); ?>" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Post a Job
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/employer/dashboard.blade.php ENDPATH**/ ?>