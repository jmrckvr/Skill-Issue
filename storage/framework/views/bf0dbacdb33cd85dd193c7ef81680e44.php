<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Jobs - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <!-- Main Layout: Sidebar + Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <?php if (isset($component)) { $__componentOriginal3e8bfe9eaf3c1db168ef1605a7faf754 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3e8bfe9eaf3c1db168ef1605a7faf754 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.applicant-sidebar','data' => ['user' => $user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('applicant-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3e8bfe9eaf3c1db168ef1605a7faf754)): ?>
<?php $attributes = $__attributesOriginal3e8bfe9eaf3c1db168ef1605a7faf754; ?>
<?php unset($__attributesOriginal3e8bfe9eaf3c1db168ef1605a7faf754); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3e8bfe9eaf3c1db168ef1605a7faf754)): ?>
<?php $component = $__componentOriginal3e8bfe9eaf3c1db168ef1605a7faf754; ?>
<?php unset($__componentOriginal3e8bfe9eaf3c1db168ef1605a7faf754); ?>
<?php endif; ?>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-6">Activity</h1>

                        <!-- Tabs -->
                        <div class="flex gap-8 border-b border-gray-200">
                            <button onclick="switchTab('saved')" 
                                    id="savedTab"
                                    class="px-4 py-3 font-medium border-b-2 border-blue-600 text-blue-600 transition">
                                📌 Saved
                            </button>
                            <button onclick="switchTab('applied')" 
                                    id="appliedTab"
                                    class="px-4 py-3 font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 transition">
                                ⭕ Applied
                            </button>
                        </div>
                    </div>

                    <!-- Saved Jobs Tab -->
                    <div id="savedContent" class="tab-content">
                        <?php if($savedJobs && $savedJobs->count() > 0): ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $savedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo e($job->title); ?></h3>
                                                <?php if($job->company): ?>
                                                    <p class="text-gray-600 mb-3"><?php echo e($job->company->name); ?></p>
                                                <?php endif; ?>
                                                <div class="flex flex-wrap gap-3 mb-4">
                                                    <?php if($job->location): ?>
                                                        <span class="text-sm text-gray-600">📍 <?php echo e($job->location); ?></span>
                                                    <?php endif; ?>
                                                    <?php if($job->salary_min && $job->salary_max): ?>
                                                        <span class="text-sm text-gray-600">💰 $<?php echo e(number_format($job->salary_min)); ?> - $<?php echo e(number_format($job->salary_max)); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="text-sm text-gray-600">Saved <?php echo e($job->created_at->diffForHumans()); ?></p>
                                            </div>
                                            <div class="flex-shrink-0 flex gap-2">
                                                <a href="<?php echo e(route('jobs.show', $job)); ?>" 
                                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                                    View
                                                </a>
                                                <form action="<?php echo e(route('jobs.save', $job)); ?>" method="POST" style="display: inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded-lg transition" title="Remove from saved">
                                                        ❌
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                                <div class="mb-6">
                                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">No saved jobs yet</h2>
                                <p class="text-gray-600 mb-8">Save jobs you're interested in so you can come back to them later.</p>
                                <a href="<?php echo e(route('jobs.search')); ?>" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                    Browse Jobs
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Applied Tab -->
                    <div id="appliedContent" class="tab-content hidden">
                        <?php if($applications && $applications->count() > 0): ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo e($app->job->title); ?></h3>
                                                <?php if($app->job->company): ?>
                                                    <p class="text-gray-600 mb-3"><?php echo e($app->job->company->name); ?></p>
                                                <?php endif; ?>
                                                <p class="text-sm text-gray-600 mb-4">Applied <?php echo e($app->created_at->diffForHumans()); ?></p>
                                            </div>
                                            <div class="flex-shrink-0 text-right">
                                                <span class="inline-block px-4 py-2 rounded-full font-semibold text-sm <?php switch($app->application_status ?? 'pending'):
                                                    case ('pending'): ?>
                                                        bg-yellow-100 text-yellow-800
                                                        <?php break; ?>
                                                    <?php case ('reviewed'): ?>
                                                        bg-blue-100 text-blue-800
                                                        <?php break; ?>
                                                    <?php case ('rejected'): ?>
                                                        bg-red-100 text-red-800
                                                        <?php break; ?>
                                                    <?php case ('hired'): ?>
                                                        bg-green-100 text-green-800
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        bg-gray-100 text-gray-800
                                                <?php endswitch; ?>">
                                                    <?php echo e(ucfirst($app->application_status ?? 'pending')); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                                <div class="mb-6">
                                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">No applications yet</h2>
                                <p class="text-gray-600 mb-8">Apply for jobs now and see your applications here.</p>
                                <a href="<?php echo e(route('jobs.search')); ?>" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                    Apply for Jobs
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all tab contents
            document.getElementById('savedContent').classList.add('hidden');
            document.getElementById('appliedContent').classList.add('hidden');

            // Remove active state from all tabs
            document.getElementById('savedTab').classList.remove('border-blue-600', 'text-blue-600');
            document.getElementById('savedTab').classList.add('border-transparent', 'text-gray-600');
            document.getElementById('appliedTab').classList.remove('border-blue-600', 'text-blue-600');
            document.getElementById('appliedTab').classList.add('border-transparent', 'text-gray-600');

            // Show selected tab content
            if (tab === 'saved') {
                document.getElementById('savedContent').classList.remove('hidden');
                document.getElementById('savedTab').classList.remove('border-transparent', 'text-gray-600');
                document.getElementById('savedTab').classList.add('border-blue-600', 'text-blue-600');
            } else if (tab === 'applied') {
                document.getElementById('appliedContent').classList.remove('hidden');
                document.getElementById('appliedTab').classList.remove('border-transparent', 'text-gray-600');
                document.getElementById('appliedTab').classList.add('border-blue-600', 'text-blue-600');
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/applicant/saved-jobs.blade.php ENDPATH**/ ?>