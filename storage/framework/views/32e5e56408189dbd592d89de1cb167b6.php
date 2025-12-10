<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(isset($job) ? 'Edit' : 'Create'); ?> Job - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-12">
            <a href="<?php echo e(route('employer.jobs.index')); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-semibold mb-4 inline-block">← Back to Job Listings</a>
            <h1 class="text-4xl font-bold text-gray-900"><?php echo e(isset($job) ? '✎ Edit Job Listing' : '➕ Create New Job Listing'); ?></h1>
            <p class="text-gray-600 mt-3"><?php echo e(isset($job) ? 'Update your job posting details to attract the right candidates' : 'Fill in the details below to post a job and start receiving applications'); ?></p>
        </div>

        <!-- Form -->
        <form action="<?php echo e(isset($job) ? route('employer.jobs.update', $job) : route('employer.jobs.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($job)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8 border-l-4 border-blue-600">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white text-sm">1</span>
                        Basic Information
                    </h2>
                    <p class="text-gray-600 mt-2">Essential job posting information</p>
                </div>

                <div class="space-y-6">
                    <!-- Job Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="<?php echo e(old('title', $job->title ?? '')); ?>" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="e.g., Senior Software Engineer">
                        <p class="text-gray-500 text-xs mt-1">Be specific and descriptive about the position</p>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Location & Job Type Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location <span class="text-red-500">*</span></label>
                            <input type="text" id="location" name="location" value="<?php echo e(old('location', $job->location ?? '')); ?>" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="e.g., Manila, Philippines">
                            <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Job Type -->
                        <div>
                            <label for="job_type" class="block text-sm font-semibold text-gray-700 mb-2">Job Type <span class="text-red-500">*</span></label>
                            <select id="job_type" name="job_type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['job_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select Job Type</option>
                                <option value="full-time" <?php echo e(old('job_type', $job->job_type ?? '') === 'full-time' ? 'selected' : ''); ?>>🏢 Full Time</option>
                                <option value="part-time" <?php echo e(old('job_type', $job->job_type ?? '') === 'part-time' ? 'selected' : ''); ?>>⏰ Part Time</option>
                                <option value="contract" <?php echo e(old('job_type', $job->job_type ?? '') === 'contract' ? 'selected' : ''); ?>>📋 Contract</option>
                                <option value="temporary" <?php echo e(old('job_type', $job->job_type ?? '') === 'temporary' ? 'selected' : ''); ?>>📅 Temporary</option>
                                <option value="freelance" <?php echo e(old('job_type', $job->job_type ?? '') === 'freelance' ? 'selected' : ''); ?>>💻 Freelance</option>
                            </select>
                            <?php $__errorArgs = ['job_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Experience Level & Category Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Experience Level -->
                        <div>
                            <label for="experience_level" class="block text-sm font-semibold text-gray-700 mb-2">Experience Level <span class="text-red-500">*</span></label>
                            <select id="experience_level" name="experience_level" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['experience_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select Experience Level</option>
                                <option value="entry" <?php echo e(old('experience_level', $job->experience_level ?? '') === 'entry' ? 'selected' : ''); ?>>📍 Entry Level</option>
                                <option value="mid" <?php echo e(old('experience_level', $job->experience_level ?? '') === 'mid' ? 'selected' : ''); ?>>⭐ Mid Level</option>
                                <option value="senior" <?php echo e(old('experience_level', $job->experience_level ?? '') === 'senior' ? 'selected' : ''); ?>>🌟 Senior Level</option>
                                <option value="executive" <?php echo e(old('experience_level', $job->experience_level ?? '') === 'executive' ? 'selected' : ''); ?>>👔 Executive</option>
                            </select>
                            <?php $__errorArgs = ['experience_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $job->category_id ?? '') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Job Details -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8 border-l-4 border-green-600">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white text-sm">2</span>
                        Job Details
                    </h2>
                    <p class="text-gray-600 mt-2">Describe the role and what you're looking for</p>
                </div>

                <div class="space-y-6">
                    <!-- Job Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Job Description <span class="text-red-500">*</span></label>
                        <textarea id="description" name="description" rows="7" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Describe the role, responsibilities, and what you're looking for..."><?php echo e(old('description', $job->description ?? '')); ?></textarea>
                        <p class="text-gray-500 text-xs mt-1">Include key responsibilities, reporting structure, and day-to-day activities</p>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Requirements -->
                    <div>
                        <label for="requirements" class="block text-sm font-semibold text-gray-700 mb-2">Requirements <span class="text-gray-500">(Optional)</span></label>
                        <textarea id="requirements" name="requirements" rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['requirements'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="List key requirements (e.g., Bachelor's degree, 5+ years experience, specific skills)..."><?php echo e(old('requirements', $job->requirements ?? '')); ?></textarea>
                        <p class="text-gray-500 text-xs mt-1">Be specific about education, experience, and skills required</p>
                        <?php $__errorArgs = ['requirements'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Benefits -->
                    <div>
                        <label for="benefits" class="block text-sm font-semibold text-gray-700 mb-2">Benefits <span class="text-gray-500">(Optional)</span></label>
                        <textarea id="benefits" name="benefits" rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['benefits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="List benefits offered (e.g., Health insurance, Remote work, Stock options, Professional development)..."><?php echo e(old('benefits', $job->benefits ?? '')); ?></textarea>
                        <p class="text-gray-500 text-xs mt-1">Highlight what makes your job offer attractive</p>
                        <?php $__errorArgs = ['benefits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Section 3: Salary & Media -->
            <div class="bg-white rounded-lg shadow-md p-8 border-l-4 border-purple-600">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-600 text-white text-sm">3</span>
                        Salary & Media
                    </h2>
                    <p class="text-gray-600 mt-2">Compensation and visual branding</p>
                </div>

                <div class="space-y-6">
                    <!-- Salary Information Row -->
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-lg border border-purple-200">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <span>💰</span> Salary Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Salary Min -->
                            <div>
                                <label for="salary_min" class="block text-sm font-semibold text-gray-700 mb-2">Minimum Salary <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-600 font-semibold">₱</span>
                                    <input type="number" id="salary_min" name="salary_min" value="<?php echo e(old('salary_min', $job->salary_min ?? '')); ?>" required min="0" step="1000"
                                        class="w-full pl-8 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['salary_min'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="50000">
                                </div>
                                <?php $__errorArgs = ['salary_min'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Salary Max -->
                            <div>
                                <label for="salary_max" class="block text-sm font-semibold text-gray-700 mb-2">Maximum Salary <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-600 font-semibold">₱</span>
                                    <input type="number" id="salary_max" name="salary_max" value="<?php echo e(old('salary_max', $job->salary_max ?? '')); ?>" required min="0" step="1000"
                                        class="w-full pl-8 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['salary_max'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="100000">
                                </div>
                                <?php $__errorArgs = ['salary_max'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Currency -->
                            <div>
                                <label for="currency" class="block text-sm font-semibold text-gray-700 mb-2">Currency <span class="text-red-500">*</span></label>
                                <select id="currency" name="currency" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="PHP" <?php echo e(old('currency', $job->currency ?? 'PHP') === 'PHP' ? 'selected' : ''); ?>>PHP - Philippine Peso</option>
                                    <option value="USD" <?php echo e(old('currency', $job->currency ?? '') === 'USD' ? 'selected' : ''); ?>>USD - US Dollar</option>
                                    <option value="EUR" <?php echo e(old('currency', $job->currency ?? '') === 'EUR' ? 'selected' : ''); ?>>EUR - Euro</option>
                                </select>
                                <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Hide Salary -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="hide_salary" value="1" <?php echo e(old('hide_salary', $job->hide_salary ?? false) ? 'checked' : ''); ?>

                                    class="w-4 h-4 rounded border-gray-300 focus:ring-2 focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Hide salary information from job listing</span>
                            </label>
                        </div>
                    </div>

                    <!-- Job Logo -->
                    <div>
                        <label for="logo" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <span>🖼️</span> Job Logo <span class="text-gray-500 font-normal">(Optional)</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Logo Preview -->
                            <?php if(isset($job) && $job->logo): ?>
                                <?php
                                    $logoUrl = null;
                                    if ($job->logo) {
                                        if (filter_var($job->logo, FILTER_VALIDATE_URL)) {
                                            $logoUrl = $job->logo;
                                        } elseif (str_starts_with($job->logo, 'logos/') || file_exists(public_path($job->logo))) {
                                            $logoUrl = asset($job->logo);
                                        } else {
                                            $logoUrl = asset('storage/' . $job->logo);
                                        }
                                    }
                                ?>
                                <div class="bg-gray-50 p-4 rounded-lg border-2 border-dashed border-gray-300">
                                    <p class="text-xs text-gray-600 font-semibold mb-2 uppercase">Current Logo</p>
                                    <img src="<?php echo e($logoUrl); ?>" alt="Job Logo" class="w-full h-32 object-cover rounded">
                                </div>
                            <?php endif; ?>
                            
                            <!-- Logo Upload -->
                            <div class="md:col-span-2">
                                <div class="bg-blue-50 p-6 rounded-lg border-2 border-dashed border-blue-300">
                                    <input type="file" id="logo" name="logo" accept="image/*" class="w-full">
                                    <p class="text-gray-600 text-sm mt-3">
                                        <strong>Supported formats:</strong> PNG, JPG, GIF (max 2MB)
                                    </p>
                                    <p class="text-gray-500 text-xs mt-2">Click to select a logo or drag and drop</p>
                                </div>
                                <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-8 border-t border-gray-200">
                <a href="<?php echo e(route('employer.jobs.index')); ?>" class="px-8 py-3 text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 font-semibold transition">
                    ← Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 font-semibold transition shadow-md">
                    <?php echo e(isset($job) ? '✓ Update Job Listing' : '➕ Post Job Listing'); ?>

                </button>
            </div>
        </form>
    </div>

    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('File selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/employer/jobs/create.blade.php ENDPATH**/ ?>