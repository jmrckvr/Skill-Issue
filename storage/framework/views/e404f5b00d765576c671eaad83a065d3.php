<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - JobStreet</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Application Details</h1>
                <p class="text-gray-600 mt-2">Job: <span class="font-semibold"><?php echo e($job->title); ?></span></p>
            </div>
            <a href="<?php echo e(route('employer.jobs.applicants', $job)); ?>" class="text-blue-600 hover:text-blue-700 font-medium">← Back to Applicants</a>
        </div>

        <!-- Flash Messages -->
        <?php if(session('success')): ?>
            <div class="mb-6">
                <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success']); ?>
                    <?php echo e(session('success')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6">
                <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error']); ?>
                    <?php echo e(session('error')); ?>

                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Applicant Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Applicant Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start gap-4 mb-6">
                        <?php if($application->applicant_profile_picture): ?>
                            <img src="<?php echo e(asset('storage/' . $application->applicant_profile_picture)); ?>" alt="<?php echo e($application->applicant_name); ?>" class="w-20 h-20 rounded-full object-cover">
                        <?php else: ?>
                            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl">
                                <?php echo e(substr($application->applicant_name, 0, 1)); ?>

                            </div>
                        <?php endif; ?>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900"><?php echo e($application->applicant_name); ?></h2>
                            <p class="text-gray-600 text-sm">Applied <?php echo e($application->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-6 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Email</p>
                            <a href="mailto:<?php echo e($application->applicant_email); ?>" class="text-blue-600 hover:text-blue-700 font-medium text-sm"><?php echo e($application->applicant_email); ?></a>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Phone</p>
                            <p class="text-gray-900 font-medium text-sm"><?php echo e($application->applicant_phone ?? 'Not provided'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Location</p>
                            <p class="text-gray-900 font-medium text-sm"><?php echo e($application->applicant_location ?? '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Status</p>
                            <p class="text-gray-900 font-medium text-sm capitalize"><?php echo e($application->status); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Applicant Skills & Bio -->
                <?php if($application->applicant_skills || $application->applicant_bio): ?>
                    <div class="bg-white rounded-lg shadow p-6">
                        <?php if($application->applicant_skills): ?>
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Skills</h3>
                                <div class="flex flex-wrap gap-2">
                                    <?php $__currentLoopData = explode(',', $application->applicant_skills); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <?php echo e(trim($skill)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($application->applicant_bio): ?>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-3">About</h3>
                                <p class="text-gray-700 leading-relaxed"><?php echo e($application->applicant_bio); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Cover Letter -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Cover Letter</h3>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($application->cover_letter ?? 'No cover letter provided.'); ?></p>
                    </div>
                </div>

                <!-- Application Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Application Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-3 h-3 bg-blue-600 rounded-full mt-2"></div>
                                <div class="w-0.5 h-16 bg-gray-200 mt-2"></div>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Application Submitted</p>
                                <p class="text-gray-600 text-sm"><?php echo e($application->created_at->format('M d, Y \a\t H:i')); ?></p>
                            </div>
                        </div>

                        <?php if($application->status !== 'pending'): ?>
                            <div class="flex items-start gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 <?php echo e($application->status === 'accepted' ? 'bg-green-600' : 'bg-red-600'); ?> rounded-full mt-2"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Application <?php echo e(ucfirst($application->status)); ?></p>
                                    <p class="text-gray-600 text-sm"><?php echo e($application->updated_at->format('M d, Y \a\t H:i')); ?></p>
                                    <?php if($application->rejection_reason): ?>
                                        <p class="text-gray-700 mt-2 bg-red-50 p-3 rounded border border-red-200">
                                            <span class="font-semibold">Reason:</span> <?php echo e($application->rejection_reason); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Status</h3>
                    <div class="mb-6">
                        <?php if($application->status === 'pending'): ?>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">Pending Review</span>
                        <?php elseif($application->status === 'accepted'): ?>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">Approved</span>
                        <?php elseif($application->status === 'rejected'): ?>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">Rejected</span>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <?php if($application->status === 'pending'): ?>
                        <div class="space-y-2">
                            <form action="<?php echo e(route('employer.applicants.approve', ['job' => $job, 'application' => $application])); ?>" method="POST" class="block">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
                                    ✓ Approve
                                </button>
                            </form>
                            <button type="button" onclick="openRejectModal()" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition">
                                ✗ Reject
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Resume Download -->
                <?php if($application->resume_path): ?>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Resume</h3>
                        <a href="<?php echo e(route('employer.application.download-resume', ['job' => $job, 'application' => $application])); ?>" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition block text-center">
                            📄 Download Resume
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Application Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Information</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">Applied on</p>
                            <p class="font-semibold text-gray-900"><?php echo e($application->created_at->format('M d, Y')); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Job Title</p>
                            <p class="font-semibold text-gray-900"><?php echo e($job->title); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Location</p>
                            <p class="font-semibold text-gray-900"><?php echo e($job->location); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Application</h3>
            <p class="text-gray-600 mb-4">Provide a reason for rejection:</p>
            <form action="<?php echo e(route('employer.applicants.reject', ['job' => $job, 'application' => $application])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <textarea name="rejection_reason" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Provide feedback to the applicant..."></textarea>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Reject</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/employer/jobs/application-detail.blade.php ENDPATH**/ ?>