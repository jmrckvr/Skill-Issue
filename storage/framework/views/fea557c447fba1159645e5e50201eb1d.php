<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo e($job->title); ?> - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Job Header Card -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex items-start gap-6">
                <!-- Company Logo -->
                <div class="flex-shrink-0">
                    <?php if($job->company->logo_path): ?>
                        <?php if(filter_var($job->company->logo_path, FILTER_VALIDATE_URL)): ?>
                            <img src="<?php echo e($job->company->logo_path); ?>" alt="<?php echo e($job->company->name); ?>" 
                                class="w-20 h-20 rounded-lg object-cover">
                        <?php else: ?>
                            <img src="<?php echo e(asset('storage/' . $job->company->logo_path)); ?>" alt="<?php echo e($job->company->name); ?>" 
                                class="w-20 h-20 rounded-lg object-cover">
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-2xl"><?php echo e(substr($job->company->name, 0, 1)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Job Info -->
                <div class="flex-1">
                    <p class="text-sm text-gray-600 mb-2">Applying for</p>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo e($job->title); ?></h1>
                    <p class="text-gray-600 mb-4"><?php echo e($job->company->name); ?></p>
                    <a href="<?php echo e(route('jobs.show', $job)); ?>" class="text-blue-600 hover:text-blue-800 underline text-sm font-medium">View job description</a>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <div class="bg-white rounded-lg shadow p-8">
            <form action="<?php echo e(route('applications.store', $job)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Section: Your Information -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Your Information</h3>
                    
                    <!-- Full Name -->
                    <div class="mb-4">
                        <label for="applicant_name" class="block text-sm font-semibold text-gray-900 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="applicant_name" name="applicant_name" value="<?php echo e(auth()->user()->name); ?>" required
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 <?php echo e($errors->has('applicant_name') ? 'border-red-500' : ''); ?>"
                            placeholder="Your full name">
                        <?php $__errorArgs = ['applicant_name'];
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

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="applicant_email" class="block text-sm font-semibold text-gray-900 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="applicant_email" name="applicant_email" value="<?php echo e(auth()->user()->email); ?>" readonly
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg bg-gray-50"
                            placeholder="your@email.com">
                        <?php $__errorArgs = ['applicant_email'];
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

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="applicant_phone" class="block text-sm font-semibold text-gray-900 mb-2">Phone Number</label>
                        <input type="tel" id="applicant_phone" name="applicant_phone" value="<?php echo e(auth()->user()->contact_number ?? ''); ?>"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 <?php echo e($errors->has('applicant_phone') ? 'border-red-500' : ''); ?>"
                            placeholder="+63 9XX XXX XXXX">
                        <?php $__errorArgs = ['applicant_phone'];
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

                    <!-- Location -->
                    <div class="mb-4">
                        <label for="applicant_location" class="block text-sm font-semibold text-gray-900 mb-2">Location</label>
                        <input type="text" id="applicant_location" name="applicant_location" value="<?php echo e(auth()->user()->location ?? ''); ?>"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 <?php echo e($errors->has('applicant_location') ? 'border-red-500' : ''); ?>"
                            placeholder="City, Country">
                        <?php $__errorArgs = ['applicant_location'];
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

                    <!-- Skills -->
                    <div class="mb-4">
                        <label for="applicant_skills" class="block text-sm font-semibold text-gray-900 mb-2">Key Skills</label>
                        <textarea id="applicant_skills" name="applicant_skills" rows="3"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 <?php echo e($errors->has('applicant_skills') ? 'border-red-500' : ''); ?>"
                            placeholder="e.g., Laravel, JavaScript, MySQL"><?php echo e(auth()->user()->skills ?? ''); ?></textarea>
                        <?php $__errorArgs = ['applicant_skills'];
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

                    <!-- Professional Summary / Bio -->
                    <div class="mb-4">
                        <label for="applicant_bio" class="block text-sm font-semibold text-gray-900 mb-2">Professional Summary</label>
                        <textarea id="applicant_bio" name="applicant_bio" rows="3"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 <?php echo e($errors->has('applicant_bio') ? 'border-red-500' : ''); ?>"
                            placeholder="Brief professional background, experience, and achievements"><?php echo e(auth()->user()->bio ?? ''); ?></textarea>
                        <?php $__errorArgs = ['applicant_bio'];
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
                </div>

                <!-- Section: Application Documents -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Application Documents</h3>

                    <!-- Resume -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Resume <span class="text-red-500">*</span></label>
                        <div class="mt-2 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 cursor-pointer transition <?php echo e($errors->has('resume') ? 'border-red-500' : ''); ?>" id="resumeDropzone">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-3-3m3 3l3-3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="resume" class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500">
                                        <span>Upload a file</span>
                                        <input type="file" id="resume" name="resume" required accept=".pdf,.doc,.docx" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 5MB</p>
                            </div>
                        </div>
                        <div id="resumeFileName" class="mt-2 text-sm text-green-600 font-semibold hidden">
                            ✓ <span id="fileName"></span>
                        </div>
                        <?php $__errorArgs = ['resume'];
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

                    <!-- Cover Letter -->
                    <div class="mb-6">
                        <label for="cover_letter" class="block text-sm font-semibold text-gray-900 mb-2">Cover Letter (Optional)</label>
                        <textarea id="cover_letter" name="cover_letter" rows="5"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 <?php echo e($errors->has('cover_letter') ? 'border-red-500' : ''); ?>"
                            placeholder="Tell the employer why you're interested in this position and what makes you a great fit..."></textarea>
                        <?php $__errorArgs = ['cover_letter'];
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
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-6 flex gap-4">
                    <button type="submit" style="background-color: #f53a6b; color: white; padding: 14px 32px; border-radius: 6px; font-weight: 700; border: none; cursor: pointer; transition: background-color 0.3s; font-size: 16px; min-width: 200px;">
                        Submit Application
                    </button>
                    <a href="<?php echo e(route('jobs.show', $job)); ?>" class="px-8 py-3 border-2 border-gray-300 rounded-lg text-gray-900 font-semibold hover:bg-gray-50 transition inline-block">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        const resumeDropzone = document.getElementById('resumeDropzone');
        const resumeInput = document.getElementById('resume');
        const resumeFileName = document.getElementById('resumeFileName');
        const fileName = document.getElementById('fileName');

        // File input change
        if (resumeInput) {
            resumeInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    resumeFileName.classList.remove('hidden');
                }
            });
        }

        // Drag and drop
        if (resumeDropzone) {
            resumeDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-blue-500', 'bg-blue-50');
            });

            resumeDropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-500', 'bg-blue-50');
            });

            resumeDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-500', 'bg-blue-50');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    resumeInput.files = files;
                    fileName.textContent = files[0].name;
                    resumeFileName.classList.remove('hidden');
                }
            });

            // Click to upload
            resumeDropzone.addEventListener('click', function(e) {
                if (e.target.tagName !== 'INPUT') {
                    resumeInput.click();
                }
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/applications/apply.blade.php ENDPATH**/ ?>