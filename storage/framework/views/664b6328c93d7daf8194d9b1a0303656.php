<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($job->title); ?> - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <a href="<?php echo e(route('jobs.search')); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-semibold mb-6 inline-block">← Back to Job Search</a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Header Card -->
                <div class="bg-white rounded-lg shadow p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($job->title); ?></h1>
                            <p class="text-gray-700 text-lg font-semibold mb-4"><?php echo e($job->company->name); ?></p>
                        </div>
                        <div class="flex gap-4 ml-6">
                            <?php
                                $companyLogoUrl = null;
                                if ($job->company->logo_path) {
                                    if (filter_var($job->company->logo_path, FILTER_VALIDATE_URL)) {
                                        $companyLogoUrl = $job->company->logo_path;
                                    } elseif (str_starts_with($job->company->logo_path, 'logos/')) {
                                        $companyLogoUrl = asset($job->company->logo_path);
                                    } else {
                                        $companyLogoUrl = asset('storage/' . $job->company->logo_path);
                                    }
                                }
                            ?>
                            <?php if($companyLogoUrl): ?>
                                <img src="<?php echo e($companyLogoUrl); ?>" alt="<?php echo e($job->company->name); ?>" 
                                    class="w-24 h-24 rounded object-cover" loading="lazy" decoding="async" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2296%22 height=%2296%22 viewBox=%220 0 96 96%22%3E%3Crect width=%2296%22 height=%2296%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                            <?php else: ?>
                                <div class="w-24 h-24 rounded bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-2xl"><?php echo e(substr($job->company->name, 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            <?php echo e(ucfirst($job->job_type)); ?>

                        </span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                            <?php echo e(ucfirst($job->experience_level)); ?>

                        </span>
                        <?php if($job->category): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <?php echo e($job->category->name); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Key Details Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6 border-t border-gray-200">
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">📍 Location</p>
                            <p class="font-bold text-gray-900 mt-1"><?php echo e($job->location); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">💰 Salary</p>
                            <p class="font-bold text-green-600 mt-1"><?php echo e($job->getFormattedSalary()); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">📅 Posted</p>
                            <p class="font-bold text-gray-900 mt-1"><?php echo e($job->published_at->format('M d, Y')); ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600 font-semibold uppercase">👥 Applications</p>
                            <p class="font-bold text-gray-900 mt-1"><?php echo e($job->application_count ?? 0); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-lg shadow p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Job Description</h2>
                    <div class="text-gray-700 space-y-4 leading-relaxed">
                        <?php echo nl2br(e($job->description)); ?>

                    </div>
                </div>

                <!-- Requirements -->
                <?php if($job->requirements): ?>
                    <div class="bg-white rounded-lg shadow p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Requirements</h2>
                        <div class="text-gray-700 space-y-4 leading-relaxed">
                            <?php echo nl2br(e($job->requirements)); ?>

                        </div>
                    </div>
                <?php endif; ?>

                <!-- Benefits -->
                <?php if($job->benefits): ?>
                    <div class="bg-white rounded-lg shadow p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Benefits</h2>
                        <div class="text-gray-700 space-y-4 leading-relaxed">
                            <?php echo nl2br(e($job->benefits)); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1 space-y-6 h-fit lg:sticky lg:top-24">
                <!-- Apply Section -->
                <?php if(auth()->guard()->check()): ?>
                    <div class="bg-white rounded-lg shadow p-6">
                        <button type="button" onclick="window.location.href='<?php echo e(route('applications.apply', $job)); ?>'" style="display: block; background-color: #f53a6b; color: white; padding: 12px 16px; border-radius: 6px; font-weight: 700; width: 100%; border: none; cursor: pointer; transition: background-color 0.3s; margin-bottom: 12px; font-size: 15px; text-align: center;">
                            Apply Now
                        </button>
                        <button type="button" id="saveJobBtn" onclick="toggleSaveJob(event, <?php echo e($job->id); ?>)" style="background-color: <?php echo e($isSaved ? '#f59e0b' : '#f3f4f6'); ?>; color: <?php echo e($isSaved ? 'white' : '#1f2937'); ?>; padding: 12px 16px; border-radius: 6px; font-weight: 700; width: 100%; border: none; cursor: pointer; transition: all 0.3s;" data-saved="<?php echo e($isSaved ? 'true' : 'false'); ?>">
                            <?php echo e($isSaved ? '★ Saved' : '☆ Save Job'); ?>

                        </button>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-gray-900 font-semibold mb-4">Want to apply for this job?</p>
                        <a href="<?php echo e(route('login')); ?>" style="display: block; background-color: #2563eb; color: white; padding: 12px 16px; border-radius: 6px; font-weight: 700; text-align: center; text-decoration: none; margin-bottom: 10px; transition: background-color 0.3s;">
                            Login to Apply
                        </a>
                        <a href="<?php echo e(route('register')); ?>" style="display: block; background-color: #f3f4f6; color: #1f2937; padding: 12px 16px; border-radius: 6px; font-weight: 700; text-align: center; text-decoration: none; border: 1px solid #d1d5db; transition: all 0.3s;">
                            Create Account
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Company Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">About Company</h3>
                    <?php
                        $companyLogoUrl = null;
                        if ($job->company->logo_path) {
                            if (filter_var($job->company->logo_path, FILTER_VALIDATE_URL)) {
                                $companyLogoUrl = $job->company->logo_path;
                            } elseif (str_starts_with($job->company->logo_path, 'logos/')) {
                                $companyLogoUrl = asset($job->company->logo_path);
                            } else {
                                $companyLogoUrl = asset('storage/' . $job->company->logo_path);
                            }
                        }
                    ?>
                    
                    <?php if($companyLogoUrl): ?>
                        <img src="<?php echo e($companyLogoUrl); ?>" alt="<?php echo e($job->company->name); ?>" 
                            class="w-full h-32 rounded-lg object-cover mb-4" loading="lazy" decoding="async" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22128%22 viewBox=%220 0 400 128%22%3E%3Crect width=%22400%22 height=%22128%22 fill=%22%23E5E7EB%22/%3E%3C/svg%3E'">
                    <?php else: ?>
                        <div class="w-full h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg mb-4 flex items-center justify-center">
                            <span class="text-white font-bold text-4xl"><?php echo e(substr($job->company->name, 0, 1)); ?></span>
                        </div>
                    <?php endif; ?>

                    <h4 class="text-base font-bold text-gray-900 mb-3"><?php echo e($job->company->name); ?></h4>

                    <?php if($job->company->description): ?>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?php echo e($job->company->description); ?></p>
                    <?php endif; ?>

                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <?php if($job->company->industry): ?>
                            <div><span class="font-semibold">Industry:</span> <?php echo e($job->company->industry); ?></div>
                        <?php endif; ?>
                        <?php if($job->company->employee_count): ?>
                            <div><span class="font-semibold">Size:</span> <?php echo e($job->company->employee_count); ?>+ employees</div>
                        <?php endif; ?>
                        <?php if($job->company->city): ?>
                            <div><span class="font-semibold">Location:</span> <?php echo e($job->company->city); ?><?php echo e($job->company->state ? ', ' . $job->company->state : ''); ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if($job->company->website): ?>
                        <a href="<?php echo e($job->company->website); ?>" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Visit website →
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        function toggleSaveJob(e, jobId) {
            e.preventDefault();
            if (!jobId) jobId = <?php echo e($job->id); ?>;
            
            const btn = document.getElementById('saveJobBtn');
            const isSaved = btn.dataset.saved === 'true';
            const url = isSaved ? `/api/jobs/${jobId}/save` : `/api/jobs/${jobId}/save`;
            const method = isSaved ? 'DELETE' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newSavedState = !isSaved;
                    btn.dataset.saved = newSavedState ? 'true' : 'false';
                    btn.textContent = newSavedState ? '★ Saved' : '☆ Save Job';
                    btn.style.backgroundColor = newSavedState ? '#f59e0b' : '#f3f4f6';
                    btn.style.color = newSavedState ? 'white' : '#1f2937';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save job. Please try again.');
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/jobs/show.blade.php ENDPATH**/ ?>