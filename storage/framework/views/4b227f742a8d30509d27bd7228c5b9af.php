<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Threads - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-white">
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
    
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section with Background Pattern -->
    <div class="relative bg-gradient-to-r from-blue-600 via-blue-500 to-pink-500 overflow-hidden py-16 lg:py-24">
        <!-- Decorative background elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 right-10 w-72 h-72 bg-white rounded-full mix-blend-screen filter blur-3xl"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-screen filter blur-3xl"></div>
        </div>

        <div class="relative container mx-auto px-4">
            <div class="max-w-4xl">
                <div class="flex items-start gap-4 lg:gap-8">
                    <div class="bg-white bg-opacity-20 rounded-full p-3 lg:p-4 flex-shrink-0">
                        <svg class="w-10 h-10 lg:w-14 lg:h-14 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                        </svg>
                    </div>
                    <div class="text-white">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-2 lg:mb-3 leading-tight">Join our career community</h1>
                        <p class="text-white text-base sm:text-lg leading-relaxed max-w-2xl opacity-95">Share career tips and exchange stories with almost 2 million jobseekers – just like you</p>
                        <div class="mt-6 flex flex-wrap gap-6">
                            <div class="flex items-center gap-2 text-white text-sm font-medium">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                                <span>2M+ Active Members</span>
                            </div>
                            <div class="flex items-center gap-2 text-white text-sm font-medium">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Real conversations daily</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 p-6 sticky top-24">
                    <!-- Create Thread Button -->
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('community.create')); ?>" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200 flex items-center justify-center gap-2 mb-6">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.707a1 1 0 00-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414L7.586 11l-1.293 1.293a1 1 0 101.414 1.414L9 12.414l1.293 1.293a1 1 0 001.414-1.414L10.414 11l1.293-1.293z" clip-rule="evenodd"></path>
                            </svg>
                            Create thread
                        </a>
                    <?php endif; ?>

                    <!-- Featured Threads Section -->
                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-200">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <h3 class="font-bold text-gray-900">Featured threads</h3>
                        </div>
                    </div>

                    <!-- Explore Groups Section -->
                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-200">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                            <h3 class="font-bold text-gray-900">Explore all groups</h3>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">View all groups →</a>
                    </div>

                    <!-- Top Groups -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-4">Top Philippines Groups</h4>
                        <div class="space-y-4">
                            <div class="pb-4 border-b border-gray-100">
                                <h5 class="font-semibold text-gray-900 text-sm">WFH squad PH</h5>
                                <p class="text-xs text-gray-600">40.7K followers</p>
                            </div>
                            <div class="pb-4 border-b border-gray-100">
                                <h5 class="font-semibold text-gray-900 text-sm">Job search advice</h5>
                                <p class="text-xs text-gray-600">13.7K followers</p>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900 text-sm">Pinoy fresh grad careers</h5>
                                <p class="text-xs text-gray-600">17.9K followers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Featured threads</h2>

                <?php if($threads->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('community.show', $thread)); ?>" class="block group">
                                <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-gray-300 hover:shadow-md transition duration-200">
                                    <div class="flex items-start gap-4">
                                        <!-- Company Avatar/Logo -->
                                        <div class="flex-shrink-0">
                                            <?php if($thread->company->logo_path): ?>
                                                <?php
                                                    $logoUrl = null;
                                                    if (filter_var($thread->company->logo_path, FILTER_VALIDATE_URL)) {
                                                        $logoUrl = $thread->company->logo_path;
                                                    } elseif (str_starts_with($thread->company->logo_path, 'logos/')) {
                                                        $logoUrl = asset($thread->company->logo_path);
                                                    } else {
                                                        $logoUrl = asset('storage/' . $thread->company->logo_path);
                                                    }
                                                ?>
                                                <img src="<?php echo e($logoUrl); ?>" 
                                                     alt="<?php echo e($thread->company->name); ?>"
                                                     class="w-12 h-12 rounded-full object-cover"
                                                     loading="lazy" decoding="async">
                                            <?php else: ?>
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                                    <?php echo e(substr($thread->company->name, 0, 1)); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Thread Content -->
                                        <div class="flex-1 min-w-0">
                                            <div class="mb-2">
                                                <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide"><?php echo e($thread->company->name); ?></p>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition mb-2"><?php echo e($thread->title); ?></h3>
                                            <p class="text-gray-700 text-sm line-clamp-2 mb-3"><?php echo e($thread->last_message_preview); ?></p>
                                            
                                            <!-- Stats -->
                                            <div class="flex items-center gap-6 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span><?php echo e($thread->messages->count()); ?></span>
                                                </div>
                                                <div class="text-gray-500"><?php echo e($thread->last_activity_at->diffForHumans()); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        <?php echo e($threads->links()); ?>

                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Threads Yet</h3>
                        <p class="text-gray-600 mb-6">Start a conversation with a company and share your thoughts!</p>
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('community.create')); ?>" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                                Create First Thread
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                                Sign In to Create Thread
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/community/threads.blade.php ENDPATH**/ ?>