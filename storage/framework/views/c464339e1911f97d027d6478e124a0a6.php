<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Categories - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Job Categories</h1>
                <p class="text-gray-600 mt-2">Total Categories: <?php echo e($categories->total()); ?></p>
            </div>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Add Category
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-400">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-3xl mb-2"><?php echo e($category->icon); ?></p>
                            <h3 class="text-lg font-bold text-gray-900"><?php echo e($category->name); ?></h3>
                            <p class="text-gray-600 text-sm mt-1">Slug: <?php echo e($category->slug); ?></p>
                            <p class="text-gray-600 text-sm mt-2">
                                <strong><?php echo e($category->jobs_count); ?></strong> <?php echo e(Str::plural('job', $category->jobs_count)); ?>

                            </p>
                        </div>
                        <div class="space-y-2">
                            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="block text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Edit
                            </a>
                            <?php if($category->jobs_count == 0): ?>
                                <form action="<?php echo e(route('admin.categories.delete', $category)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" onclick="return confirm('Delete category?')" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">—</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div>
            <?php echo e($categories->links()); ?>

        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/admin/categories.blade.php ENDPATH**/ ?>