<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications - Skill Issue</title>
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
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">Job Applications</h1>
                        <p class="text-gray-600">Track the status of all your job applications</p>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="mb-8 flex flex-wrap gap-3">
                        <button onclick="filterApplications('all')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-blue-600 text-white" 
                                data-filter="all">
                            All
                        </button>
                        <button onclick="filterApplications('pending')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-white border border-gray-300 text-gray-700 hover:bg-gray-50" 
                                data-filter="pending">
                            ⏳ Pending
                        </button>
                        <button onclick="filterApplications('reviewed')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-white border border-gray-300 text-gray-700 hover:bg-gray-50" 
                                data-filter="reviewed">
                            👀 Reviewed
                        </button>
                        <button onclick="filterApplications('rejected')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-white border border-gray-300 text-gray-700 hover:bg-gray-50" 
                                data-filter="rejected">
                            ❌ Rejected
                        </button>
                        <button onclick="filterApplications('hired')" 
                                class="filterBtn px-4 py-2 rounded-full font-medium transition bg-white border border-gray-300 text-gray-700 hover:bg-gray-50" 
                                data-filter="hired">
                            ✅ Hired
                        </button>
                    </div>

                    <!-- Applications List -->
                    <?php if($applications && $applications->count() > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="applicationCard bg-white rounded-lg border border-gray-200 p-6 hover:border-blue-300 hover:shadow-md transition" 
                                     data-status="<?php echo e($app->status ?? 'pending'); ?>">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-start gap-4 mb-3">
                                                <?php if($app->job->company && $app->job->company->logo_path): ?>
                                                    <img src="<?php echo e(asset('storage/' . $app->job->company->logo_path)); ?>" 
                                                         alt="<?php echo e($app->job->company->name); ?>"
                                                         class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                                <?php else: ?>
                                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold border border-gray-200">
                                                        <?php echo e(substr($app->job->company->name ?? 'J', 0, 1)); ?>

                                                    </div>
                                                <?php endif; ?>
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-bold text-gray-900 mb-1"><?php echo e($app->job->title); ?></h3>
                                                    <?php if($app->job->company): ?>
                                                        <p class="text-gray-600 font-medium"><?php echo e($app->job->company->name); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap gap-3 mb-4">
                                                <?php if($app->job->location): ?>
                                                    <span class="text-sm text-gray-600">📍 <?php echo e($app->job->location); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="space-y-1 text-sm text-gray-600">
                                                <p>Applied <span class="font-medium"><?php echo e($app->created_at->format('M d, Y')); ?></span></p>
                                                <?php if($app->updated_at->ne($app->created_at)): ?>
                                                    <p>Last updated <span class="font-medium"><?php echo e($app->updated_at->diffForHumans()); ?></span></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="flex-shrink-0 text-right flex flex-col gap-3">
                                            <span class="inline-block px-4 py-2 rounded-full font-semibold text-sm <?php switch($app->status ?? 'pending'):
                                                case ('pending'): ?>
                                                    bg-yellow-100 text-yellow-800
                                                    <?php break; ?>
                                                <?php case ('reviewed'): ?>
                                                    bg-blue-100 text-blue-800
                                                    <?php break; ?>
                                                <?php case ('accepted'): ?>
                                                    bg-green-100 text-green-800
                                                    <?php break; ?>
                                                <?php case ('rejected'): ?>
                                                    bg-red-100 text-red-800
                                                    <?php break; ?>
                                                <?php default: ?>
                                                    bg-gray-100 text-gray-800
                                            <?php endswitch; ?>">
                                                <?php switch($app->status ?? 'pending'):
                                                    case ('pending'): ?>
                                                        ⏳ Pending
                                                        <?php break; ?>
                                                    <?php case ('reviewed'): ?>
                                                        👀 Reviewed
                                                        <?php break; ?>
                                                    <?php case ('accepted'): ?>
                                                        ✅ Approved
                                                        <?php break; ?>
                                                    <?php case ('rejected'): ?>
                                                        ❌ Rejected
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        Pending
                                                <?php endswitch; ?>
                                            </span>
                                            <a href="<?php echo e(route('jobs.show', $app->job)); ?>" 
                                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition text-sm text-center">
                                                View Job
                                            </a>
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
                            <p class="text-gray-600 mb-8">Start applying for jobs and track your applications here.</p>
                            <a href="<?php echo e(route('jobs.search')); ?>" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                Browse Jobs
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterApplications(status) {
            const cards = document.querySelectorAll('.applicationCard');
            const buttons = document.querySelectorAll('.filterBtn');

            // Update button styles
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-700', 'hover:bg-gray-50');
            });

            // Mark active button
            const activeBtn = Array.from(buttons).find(btn => btn.dataset.filter === status);
            if (activeBtn) {
                activeBtn.classList.add('bg-blue-600', 'text-white');
                activeBtn.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-700', 'hover:bg-gray-50');
            }

            // Filter cards
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/applicant/job-applications.blade.php ENDPATH**/ ?>