<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - JobStreet</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-8 text-center">
            <!-- Success Icon -->
            <div class="mb-6">
                <svg class="mx-auto h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Application Submitted!</h1>
            <p class="text-gray-600 text-lg mb-6">Your application for <strong><?php echo e($application->job->title); ?></strong> at <strong><?php echo e($application->job->company->name); ?></strong> has been successfully submitted.</p>

            <!-- Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Application Details</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-semibold">Position:</span>
                        <span class="text-gray-900"><?php echo e($application->job->title); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-semibold">Company:</span>
                        <span class="text-gray-900"><?php echo e($application->job->company->name); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-semibold">Submitted Date:</span>
                        <span class="text-gray-900"><?php echo e($application->created_at->format('M d, Y \a\t h:i A')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-semibold">Status:</span>
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold">Under Review</span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8 text-left">
                <h3 class="text-lg font-bold text-blue-900 mb-3">What Happens Next?</h3>
                <ul class="space-y-2 text-blue-900">
                    <li class="flex items-start">
                        <span class="font-bold mr-3">1.</span>
                        <span>We'll review your application and resume.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-3">2.</span>
                        <span>If your qualifications match, the employer will contact you.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-3">3.</span>
                        <span>You can track your application status anytime from your dashboard.</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('jobs.show', $application->job)); ?>" class="px-8 py-3 bg-gray-100 text-gray-900 rounded-lg font-semibold hover:bg-gray-200 transition text-center">
                    View Job Again
                </a>
                <a href="<?php echo e(route('jobs.search')); ?>" style="background-color: #f53a6b; color: white; padding: 12px 32px; border-radius: 6px; font-weight: 700; text-decoration: none; display: inline-block; text-align: center; transition: background-color 0.3s;">
                    Continue Job Searching
                </a>
                <a href="<?php echo e(route('applicant.job-applications')); ?>" class="px-8 py-3 border-2 border-gray-300 text-gray-900 rounded-lg font-semibold hover:bg-gray-50 transition text-center">
                    View My Applications
                </a>
            </div>
        </div>
    </div>

    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/applications/success.blade.php ENDPATH**/ ?>