<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Jobs - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">Your Job Postings</h1>
                    <p class="text-gray-600 mt-2">Manage and track all your job listings</p>
                </div>
                <a href="<?php echo e(route('employer.jobs.create')); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-md">
                    ➕ Post New Job
                </a>
            </div>

            <?php if(session('success')): ?>
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex justify-between items-center">
                    <p class="text-green-800 font-medium"><?php echo e(session('success')); ?></p>
                    <button onclick="this.parentElement.style.display='none';" class="text-green-600 hover:text-green-800">✕</button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex justify-between items-center">
                    <p class="text-red-800 font-medium"><?php echo e(session('error')); ?></p>
                    <button onclick="this.parentElement.style.display='none';" class="text-red-600 hover:text-red-800">✕</button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Jobs Cards/List -->
        <?php if($jobs->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-6">
                                <!-- Left: Logo and Job Info -->
                                <div class="flex items-start gap-4 flex-1">
                                    <!-- Logo -->
                                    <div class="flex-shrink-0">
                                        <?php
                                            $logoUrl = null;
                                            if ($job->logo) {
                                                if (filter_var($job->logo, FILTER_VALIDATE_URL)) {
                                                    $logoUrl = $job->logo;
                                                } elseif (str_starts_with($job->logo, 'logos/') || file_exists(public_path($job->logo))) {
                                                    $logoUrl = asset($job->logo);
                                                } else {
                                                    $logoUrl = asset('storage/' . $job->logo);
                                                }
                                            }
                                        ?>
                                        <?php if($logoUrl): ?>
                                            <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($job->title); ?>" class="w-16 h-16 rounded-lg object-cover border border-gray-200" loading="lazy">
                                        <?php else: ?>
                                            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                                <span class="text-gray-500 text-xs font-semibold text-center px-1"><?php echo e(substr($job->title, 0, 3)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Job Details -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-bold text-gray-900 mb-1"><?php echo e($job->title); ?></h3>
                                        <p class="text-sm text-gray-600 mb-3"><?php echo e($job->category->name ?? 'Uncategorized'); ?> • <?php echo e($job->location); ?></p>
                                        
                                        <div class="flex items-center gap-4 text-sm">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full
                                                    <?php if($job->status === 'published'): ?> bg-green-100 text-green-800
                                                    <?php elseif($job->status === 'draft'): ?> bg-yellow-100 text-yellow-800
                                                    <?php elseif($job->status === 'closed'): ?> bg-red-100 text-red-800
                                                    <?php endif; ?>">
                                                    <?php echo e(ucfirst($job->status)); ?>

                                                </span>
                                            </div>
                                            <div class="text-gray-600">
                                                📅 <?php echo e($job->created_at->format('M d, Y')); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right: Stats and Actions -->
                                <div class="flex items-center gap-8 flex-shrink-0">
                                    <!-- Applications Count -->
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-blue-600"><?php echo e($job->applications->count()); ?></div>
                                        <div class="text-xs text-gray-600 mt-1">Application<?php echo e($job->applications->count() !== 1 ? 's' : ''); ?></div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        <?php if($job->applications->count() > 0): ?>
                                            <a href="<?php echo e(route('employer.jobs.applicants', $job)); ?>" class="px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg font-medium text-sm transition whitespace-nowrap">
                                                👥 View Applicants
                                            </a>
                                        <?php else: ?>
                                            <span class="px-4 py-2 bg-gray-50 text-gray-400 rounded-lg font-medium text-sm">
                                                👥 No Applications
                                            </span>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo e(route('employer.jobs.edit', $job)); ?>" class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg font-medium text-sm transition">
                                            ✎ Edit
                                        </a>
                                        
                                        <button onclick="confirmDelete(this)" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium text-sm transition">
                                            🗑️ Delete
                                        </button>
                                        
                                        <form action="<?php echo e(route('employer.jobs.destroy', $job)); ?>" method="POST" style="display: none;" class="delete-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <?php if($jobs->hasPages()): ?>
                <div class="mt-8">
                    <?php echo e($jobs->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="mb-4 text-5xl">📋</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No Job Listings Yet</h3>
                <p class="text-gray-600 mb-6">Start by creating your first job posting to attract talented applicants.</p>
                <a href="<?php echo e(route('employer.jobs.create')); ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    ➕ Post Your First Job
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function confirmDelete(button) {
            if (confirm('Are you sure you want to delete this job posting? This action cannot be undone.')) {
                button.parentElement.querySelector('.delete-form').submit();
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/employer/jobs/index.blade.php ENDPATH**/ ?>