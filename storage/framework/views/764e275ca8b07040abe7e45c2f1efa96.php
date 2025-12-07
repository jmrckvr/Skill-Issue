<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Form - JobStreet</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">
                    <?php if(isset($category)): ?>
                        Edit Category
                    <?php else: ?>
                        Create Category
                    <?php endif; ?>
                </h1>
            </div>

            <form action="<?php if(isset($category)): ?><?php echo e(route('admin.categories.update', $category)); ?><?php else: ?><?php echo e(route('admin.categories.store')); ?><?php endif; ?>" method="POST" class="p-6 space-y-6">
                <?php echo csrf_field(); ?>
                <?php if(isset($category)): ?>
                    <?php echo method_field('PATCH'); ?>
                <?php endif; ?>

                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $category->name ?? '')); ?>" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="e.g., Information Technology"
                           required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-red-500 text-sm"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700">Icon (Emoji) <span class="text-red-500">*</span></label>
                    <div class="mt-1 flex gap-2">
                        <input type="text" name="icon" id="icon" value="<?php echo e(old('icon', $category->icon ?? '')); ?>" 
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-2xl text-center"
                               placeholder="💻"
                               maxlength="2"
                               required>
                        <div class="text-4xl mt-1"><?php echo e(old('icon', $category->icon ?? '📁')); ?></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Enter an emoji to represent this category</p>
                    <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-red-500 text-sm"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Common Emojis Quick Select -->
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Quick Select:</p>
                    <div class="flex gap-2 flex-wrap">
                        <?php $__currentLoopData = ['💻', '⚕️', '💰', '📱', '🎨', '⚙️', '📚', '🏥', '📦', '🛍️']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emoji): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" onclick="document.getElementById('icon').value = '<?php echo e($emoji); ?>'; document.querySelector('.emoji-preview').textContent = '<?php echo e($emoji); ?>';" 
                                    class="text-2xl p-2 border border-gray-300 rounded hover:bg-gray-100">
                                <?php echo e($emoji); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="<?php echo e(route('admin.categories')); ?>" class="px-6 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <?php if(isset($category)): ?>
                            Update Category
                        <?php else: ?>
                            Create Category
                        <?php endif; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/admin/category-form.blade.php ENDPATH**/ ?>