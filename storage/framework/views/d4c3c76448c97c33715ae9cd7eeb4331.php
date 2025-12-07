<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Skill Issue</title>
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
                    <!-- Profile Header Section -->
                    <div class="bg-white rounded-lg border border-gray-200 p-8 mb-8">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-8">
                    <!-- Profile Picture Section -->
                    <div class="flex-shrink-0">
                        <div class="relative group">
                            <?php if($user->profile_picture && str_starts_with($user->profile_picture, 'profile_pictures/')): ?>
                                <img src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" 
                                     alt="<?php echo e($user->name); ?>"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-blue-600">
                            <?php else: ?>
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-4xl font-bold border-4 border-blue-600">
                                    <?php echo e(substr($user->name, 0, 1)); ?>

                                </div>
                            <?php endif; ?>
                            
                            <!-- Upload Picture Form (Hidden) -->
                            <form id="profilePictureForm" method="POST" action="<?php echo e(route('applicant.upload-picture')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*" style="display: none;">
                            </form>
                            
                            <!-- Upload Button -->
                            <button onclick="document.getElementById('profilePictureInput').click()" 
                                    class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($user->name); ?></h1>
                        <p class="text-gray-600 mb-4"><?php echo e($user->email); ?></p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <?php if($user->contact_number): ?>
                                <div>
                                    <p class="text-sm text-gray-600">Phone</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($user->contact_number); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if($user->location): ?>
                                <div>
                                    <p class="text-sm text-gray-600">Location</p>
                                    <p class="font-semibold text-gray-900"><?php echo e($user->location); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            <a href="<?php echo e(route('applicant.edit-profile')); ?>" 
                               class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                Edit Profile
                            </a>
                            <button onclick="document.getElementById('resumeInput').click()"
                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                Upload Resume
                            </button>
                            <?php if($user->resume_path): ?>
                                <a href="<?php echo e(route('applicant.download-resume')); ?>"
                                   class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition">
                                    Download Resume
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Resume Upload Form (Hidden) -->
                <form id="resumeForm" method="POST" action="<?php echo e(route('applicant.upload-resume')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="file" id="resumeInput" name="resume" accept=".pdf" style="display: none;">
                </form>

                <!-- Resume Section -->
                <?php if($user->resume_path): ?>
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Resume</h3>
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1 1 0 11-2 0 1 1 0 012 0zM15 7H4v6h11V7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo e(basename($user->resume_path)); ?></p>
                                    <p class="text-sm text-gray-600">PDF Document</p>
                                </div>
                            </div>
                            <a href="<?php echo e(route('applicant.download-resume')); ?>"
                               class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold rounded-lg transition">
                                Download
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Resume</h3>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">No resume uploaded yet. Upload a PDF resume to apply for jobs.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Applications Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h2 class="text-3xl font-bold text-white mb-1">Recent Applications</h2>
                    <p class="text-blue-100">Track your job application status</p>
                </div>

                <?php if($applications->count() > 0): ?>
                    <div class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('jobs.show', $app->job->id)); ?>" class="block hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between p-6 gap-4">
                                    <!-- Left: Company Logo & Info -->
                                    <div class="flex items-start gap-4 flex-1 min-w-0">
                                        <?php if($app->job->company && $app->job->company->logo_path): ?>
                                            <?php
                                                $logoUrl = null;
                                                if (filter_var($app->job->company->logo_path, FILTER_VALIDATE_URL)) {
                                                    $logoUrl = $app->job->company->logo_path;
                                                } elseif (str_starts_with($app->job->company->logo_path, 'logos/')) {
                                                    $logoUrl = asset($app->job->company->logo_path);
                                                } else {
                                                    $logoUrl = asset('storage/' . $app->job->company->logo_path);
                                                }
                                            ?>
                                            <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($app->job->company->name); ?>" class="w-16 h-16 rounded-lg object-cover border border-gray-200 flex-shrink-0">
                                        <?php else: ?>
                                            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-lg border border-gray-200 flex-shrink-0">
                                                <?php echo e(substr($app->job->company->name ?? 'J', 0, 1)); ?>

                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-bold text-gray-900 truncate"><?php echo e($app->job->title); ?></h3>
                                            <?php if($app->job->company): ?>
                                                <p class="text-gray-600 font-medium text-sm truncate"><?php echo e($app->job->company->name); ?></p>
                                            <?php endif; ?>
                                            <div class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                                </svg>
                                                <span>Applied <?php echo e($app->created_at->diffForHumans()); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Status Badge & Arrow -->
                                    <div class="flex items-center gap-4 flex-shrink-0">
                                        <span class="inline-block px-4 py-2 rounded-full font-semibold text-sm whitespace-nowrap <?php switch($app->status ?? 'pending'):
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
                                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No applications yet</h3>
                        <p class="text-gray-600 mb-6">Start applying for jobs to see your applications here</p>
                        <a href="<?php echo e(route('jobs.search')); ?>" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                            Browse Jobs
                        </a>
                    </div>
                <?php endif; ?>
            </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-submit when file is selected
        document.getElementById('profilePictureInput').addEventListener('change', function() {
            if (this.files.length > 0) {
                document.getElementById('profilePictureForm').submit();
            }
        });

        document.getElementById('resumeInput').addEventListener('change', function() {
            if (this.files.length > 0) {
                document.getElementById('resumeForm').submit();
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/applicant/dashboard.blade.php ENDPATH**/ ?>