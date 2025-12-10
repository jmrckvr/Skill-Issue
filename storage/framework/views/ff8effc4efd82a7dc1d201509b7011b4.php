<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manage Users</h1>
                <p class="text-gray-600 mt-2">Total Users: <?php echo e($users->total()); ?></p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form action="<?php echo e(route('admin.users')); ?>" method="GET" class="flex gap-4">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by name or email..." 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                
                <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Roles</option>
                    <option value="admin" <?php if(request('role') === 'admin'): ?> selected <?php endif; ?>>Admin</option>
                    <option value="employer" <?php if(request('role') === 'employer'): ?> selected <?php endif; ?>>Employer</option>
                    <option value="applicant" <?php if(request('role') === 'applicant'): ?> selected <?php endif; ?>>Applicant</option>
                </select>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Search
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Joined</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900 font-medium"><?php echo e($user->name); ?></td>
                            <td class="px-6 py-4 text-gray-600"><?php echo e($user->email); ?></td>
                            <td class="px-6 py-4">
                                <span class="text-xs px-2 py-1 rounded-full <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800 <?php elseif($user->role === 'employer'): ?> bg-blue-100 text-blue-800 <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                                    <?php if($user->role === 'jobseeker' || $user->role === 'applicant'): ?> Applicant <?php else: ?> <?php echo e(ucfirst($user->role)); ?> <?php endif; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if($user->is_active): ?>
                                    <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">Active</span>
                                <?php else: ?>
                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                            <td class="px-6 py-4">
                                <?php if($user->id !== auth()->id()): ?>
                                    <?php if($user->is_active): ?>
                                        <form action="<?php echo e(route('admin.users.deactivate', $user)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                                Deactivate
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('admin.users.activate', $user)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                                Activate
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-gray-400 text-sm">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <?php echo e($users->appends(request()->query())->links()); ?>

        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/admin/users.blade.php ENDPATH**/ ?>