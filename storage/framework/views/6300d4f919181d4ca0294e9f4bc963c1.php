<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs - JobStreet</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manage Jobs</h1>
                <p class="text-gray-600 mt-2">Total Jobs: <?php echo e($jobs->total()); ?></p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form action="<?php echo e(route('admin.jobs')); ?>" method="GET" class="flex gap-4">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search job titles..." 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="published" <?php if(request('status') === 'published'): ?> selected <?php endif; ?>>Published</option>
                    <option value="draft" <?php if(request('status') === 'draft'): ?> selected <?php endif; ?>>Draft</option>
                    <option value="closed" <?php if(request('status') === 'closed'): ?> selected <?php endif; ?>>Closed</option>
                </select>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Search
                </button>
            </form>
        </div>

        <!-- Jobs Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Company</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Applications</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Posted</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900 font-medium"><?php echo e($job->title); ?></td>
                            <td class="px-6 py-4 text-gray-600"><?php echo e($job->company->name); ?></td>
                            <td class="px-6 py-4">
                                <span class="text-xs px-2 py-1 rounded-full <?php if($job->status === 'published'): ?> bg-green-100 text-green-800 <?php elseif($job->status === 'draft'): ?> bg-gray-100 text-gray-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($job->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-900"><?php echo e($job->application_count); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php if($job->published_at): ?>
                                    <?php echo e($job->published_at->format('M d, Y')); ?>

                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="<?php echo e(route('jobs.show', $job)); ?>" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    View
                                </a>
                                <?php if($job->trashed()): ?>
                                    <form action="<?php echo e(route('admin.jobs.restore', $job)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.jobs.permanent-delete', $job)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" onclick="return confirm('Permanently delete?')" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.jobs.permanent-delete', $job)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" onclick="return confirm('Soft delete this job?')" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            Remove
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <?php echo e($jobs->appends(request()->query())->links()); ?>

        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/admin/jobs.blade.php ENDPATH**/ ?>