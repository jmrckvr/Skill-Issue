<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For Employers - JobStreet</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body { margin: 0; padding: 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    </style>
</head>
<body class="bg-white" style="margin: 0; padding: 0;">
    <!-- Navigation -->
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); color: white; padding: 80px 20px; text-align: center; margin: 0;">
        <div class="container">
            <h1 style="font-size: 48px; font-weight: bold; margin: 0 0 20px 0; line-height: 1.2;">
                Hiring Made Easy
            </h1>
            <p style="font-size: 20px; color: #dbeafe; margin: 0 0 40px 0; max-width: 600px; margin-left: auto; margin-right: auto;">
                Post your jobs for free and find the right candidates fast
            </p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo e(route('register-employer')); ?>" style="background: #ec4899; color: white; padding: 16px 32px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block; transition: all 0.3s;">
                    Create Account
                </a>
                <a href="<?php echo e(route('login')); ?>" style="background: white; color: #1e40af; padding: 16px 32px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block; transition: all 0.3s;">
                    Sign In
                </a>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div style="padding: 80px 20px; background: white;">
        <div class="container">
            <h2 style="font-size: 40px; font-weight: bold; text-align: center; color: #111827; margin: 0 0 50px 0;">Start Hiring in 3 Simple Steps</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <!-- Step 1 -->
                <div style="background: #f0f9ff; padding: 40px 30px; border-radius: 12px; position: relative;">
                    <div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); background: #ec4899; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24px;">1</div>
                    <div style="margin-top: 20px;">
                        <h3 style="font-size: 24px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Register Account</h3>
                        <p style="color: #4b5563; margin: 0; line-height: 1.6;">Create and verify your company account with your email address in just a few minutes.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div style="background: #f0f9ff; padding: 40px 30px; border-radius: 12px; position: relative;">
                    <div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); background: #ec4899; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24px;">2</div>
                    <div style="margin-top: 20px;">
                        <h3 style="font-size: 24px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Post a Job</h3>
                        <p style="color: #4b5563; margin: 0; line-height: 1.6;">Use our easy job posting form to describe your opening and requirements.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div style="background: #f0f9ff; padding: 40px 30px; border-radius: 12px; position: relative;">
                    <div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); background: #ec4899; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24px;">3</div>
                    <div style="margin-top: 20px;">
                        <h3 style="font-size: 24px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Review & Hire</h3>
                        <p style="color: #4b5563; margin: 0; line-height: 1.6;">Review qualified candidates and make your hiring decisions quickly and easily.</p>
                    </div>
                </div>
            </div>

            <!-- Start Button -->
            <div style="text-align: center; margin-top: 50px;">
                <a href="<?php echo e(route('register-employer')); ?>" style="background: #2563eb; color: white; padding: 16px 40px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block; font-size: 16px; transition: all 0.3s;">
                    Start Hiring for FREE
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div style="padding: 80px 20px; background: #f9fafb;">
        <div class="container">
            <h2 style="font-size: 40px; font-weight: bold; text-align: center; color: #111827; margin: 0 0 50px 0;">Why Choose JobStreet?</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                <!-- Feature 1 -->
                <div style="background: white; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 40px; margin-bottom: 15px;">💰</div>
                    <h3 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Free Job Posting</h3>
                    <p style="color: #4b5563; margin: 0; font-size: 14px; line-height: 1.6;">Post unlimited job openings at no cost.</p>
                </div>

                <!-- Feature 2 -->
                <div style="background: white; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 40px; margin-bottom: 15px;">🤖</div>
                    <h3 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Smart Matching</h3>
                    <p style="color: #4b5563; margin: 0; font-size: 14px; line-height: 1.6;">AI system matches your jobs with qualified candidates.</p>
                </div>

                <!-- Feature 3 -->
                <div style="background: white; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 40px; margin-bottom: 15px;">📊</div>
                    <h3 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Easy Dashboard</h3>
                    <p style="color: #4b5563; margin: 0; font-size: 14px; line-height: 1.6;">Manage applications and communicate with candidates.</p>
                </div>

                <!-- Feature 4 -->
                <div style="background: white; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 40px; margin-bottom: 15px;">👥</div>
                    <h3 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Large Talent Pool</h3>
                    <p style="color: #4b5563; margin: 0; font-size: 14px; line-height: 1.6;">Access over 50,000 qualified job seekers.</p>
                </div>

                <!-- Feature 5 -->
                <div style="background: white; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 40px; margin-bottom: 15px;">⚡</div>
                    <h3 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Fast Hiring</h3>
                    <p style="color: #4b5563; margin: 0; font-size: 14px; line-height: 1.6;">Get qualified candidates quickly and efficiently.</p>
                </div>

                <!-- Feature 6 -->
                <div style="background: white; padding: 30px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <div style="font-size: 40px; margin-bottom: 15px;">🔐</div>
                    <h3 style="font-size: 18px; font-weight: bold; color: #111827; margin: 0 0 10px 0;">Secure & Safe</h3>
                    <p style="color: #4b5563; margin: 0; font-size: 14px; line-height: 1.6;">Enterprise-grade security for your data.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white; padding: 60px 20px; text-align: center;">
        <div class="container">
            <h2 style="font-size: 40px; font-weight: bold; margin: 0 0 20px 0;">Ready to Start Hiring?</h2>
            <p style="font-size: 18px; color: #dbeafe; margin: 0 0 30px 0; max-width: 600px; margin-left: auto; margin-right: auto;">
                Join hundreds of companies hiring on JobStreet. It's free, fast, and easy.
            </p>
            <a href="<?php echo e(route('register-employer')); ?>" style="background: #ec4899; color: white; padding: 16px 40px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block; font-size: 16px; transition: all 0.3s;">
                Create Your Account Now
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: #111827; color: #9ca3af; padding: 40px 20px; text-align: center;">
        <div class="container">
            <p style="margin: 0; font-size: 14px;">&copy; 2024 JobStreet. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\jmrck\Project Folder\Skill1ssue\jobstreet\resources\views/employer/landing.blade.php ENDPATH**/ ?>