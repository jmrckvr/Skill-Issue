<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Skill Issue</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <a href="<?php echo e(route('home')); ?>" class="inline-block">
                    <div class="text-3xl font-bold text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Skill Issue</div>
                </a>
            </div>

            <!-- Success Message -->
            <?php if(session('status')): ?>
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800 text-sm font-semibold"><?php echo e(session('status')); ?></p>
                </div>
            <?php endif; ?>

            <!-- Forgot Password Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Reset Password</h2>
                <p class="text-gray-600 text-sm mb-6">
                    Enter your email address and we'll send you a link to reset your password.
                </p>
                
                <form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo e(old('email')); ?>"
                            placeholder="you@example.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required
                            autofocus
                        />
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 transform hover:scale-105 active:scale-95"
                    >
                        Send Reset Link
                    </button>
                </form>
            </div>

            <!-- Back to Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-700">
                    Remember your password?
                    <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Back to sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>