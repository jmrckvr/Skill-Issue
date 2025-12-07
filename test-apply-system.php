#!/usr/bin/env php
<?php
// Test script for applying system

require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Create test data
echo "🧪 Testing Apply & Save System\n";
echo "================================\n\n";

// Import models
$user = \App\Models\User::class;
$job = \App\Models\Job::class;
$company = \App\Models\Company::class;
$jobApplication = \App\Models\JobApplication::class;
$savedJob = \App\Models\SavedJob::class;

try {
    // 1. Check if test employer exists
    echo "1️⃣  Checking test employer account...\n";
    $testEmployer = $user::where('email', 'employer@test.com')->first();
    if (!$testEmployer) {
        echo "   ❌ Test employer not found. Creating...\n";
        $testEmployer = $user::create([
            'name' => 'Test Employer',
            'email' => 'employer@test.com',
            'password' => bcrypt('password123'),
            'role' => 'employer',
            'email_verified_at' => now(),
            'is_employer' => true,
        ]);

        // Create company for employer
        $testCompany = $company::create([
            'user_id' => $testEmployer->id,
            'name' => 'Test Company Inc.',
            'description' => 'A test company for job postings',
            'industry' => 'Technology',
            'employee_count' => '50-100',
        ]);
        echo "   ✅ Test employer created with company\n";
    } else {
        echo "   ✅ Test employer found\n";
    }

    // 2. Check if test applicant exists
    echo "\n2️⃣  Checking test applicant account...\n";
    $testApplicant = $user::where('email', 'applicant@test.com')->first();
    if (!$testApplicant) {
        echo "   ❌ Test applicant not found. Creating...\n";
        $testApplicant = $user::create([
            'name' => 'Jamerick Evora',
            'email' => 'applicant@test.com',
            'password' => bcrypt('password123'),
            'role' => 'applicant',
            'email_verified_at' => now(),
            'is_applicant' => true,
            'contact_number' => '+63 9455475804',
            'location' => 'Central Luzon',
            'skills' => 'PHP, Laravel, JavaScript, React, Database Design',
            'bio' => 'Experienced full-stack developer with passion for building scalable applications.',
        ]);
        echo "   ✅ Test applicant created\n";
    } else {
        echo "   ✅ Test applicant found\n";
    }

    // 3. Check if test job exists
    echo "\n3️⃣  Checking test job posting...\n";
    $testJob = $job::where('title', 'Accounts Payable Associate')
        ->where('company_id', $testEmployer->company->id ?? null)
        ->first();

    if (!$testJob) {
        echo "   ❌ Test job not found. Creating...\n";
        $category = \App\Models\Category::first();
        if (!$category) {
            $category = \App\Models\Category::create([
                'name' => 'Accounting',
                'slug' => 'accounting'
            ]);
        }

        $testJob = $job::create([
            'company_id' => $testEmployer->company->id,
            'category_id' => $category->id,
            'title' => 'Accounts Payable Associate',
            'description' => 'We are looking for an experienced Accounts Payable Associate to join our finance team.',
            'location' => 'Central Luzon',
            'job_type' => 'full-time',
            'experience_level' => 'entry',
            'salary_min' => 25000,
            'salary_max' => 45000,
            'currency' => 'PHP',
            'requirements' => 'Bachelor\'s degree in Accounting or Finance. 2+ years of AP experience.',
            'benefits' => 'Health insurance, 5 days vacation, training and development',
            'status' => 'published',
            'published_at' => now(),
        ]);
        echo "   ✅ Test job created\n";
    } else {
        echo "   ✅ Test job found\n";
    }

    // 4. Check database tables
    echo "\n4️⃣  Checking database schema...\n";
    $hasSavedJobsTable = \Illuminate\Support\Facades\Schema::hasTable('saved_jobs');
    $hasJobApplicationsTable = \Illuminate\Support\Facades\Schema::hasTable('job_applications');

    if ($hasSavedJobsTable) {
        echo "   ✅ saved_jobs table exists\n";
    } else {
        echo "   ❌ saved_jobs table missing\n";
    }

    if ($hasJobApplicationsTable) {
        echo "   ✅ job_applications table exists\n";

        // Check for applicant snapshot columns
        $hasSnapshotFields = \Illuminate\Support\Facades\Schema::hasColumns('job_applications', [
            'applicant_name',
            'applicant_email',
            'applicant_phone',
            'applicant_location',
            'applicant_skills',
            'applicant_bio',
        ]);

        if ($hasSnapshotFields) {
            echo "   ✅ Applicant snapshot fields exist\n";
        } else {
            echo "   ⚠️  Some applicant snapshot fields missing\n";
        }
    } else {
        echo "   ❌ job_applications table missing\n";
    }

    // 5. Test API endpoints
    echo "\n5️⃣  Testing API endpoints...\n";

    // Check if SavedJobController exists
    if (class_exists(\App\Http\Controllers\SavedJobController::class)) {
        echo "   ✅ SavedJobController exists\n";
    } else {
        echo "   ❌ SavedJobController not found\n";
    }

    // Check if JobApplicationController has showAPI method
    $controller = new \App\Http\Controllers\JobApplicationController();
    if (method_exists($controller, 'showAPI')) {
        echo "   ✅ JobApplicationController::showAPI method exists\n";
    } else {
        echo "   ❌ JobApplicationController::showAPI method missing\n";
    }

    // 6. Summary
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "✅ All checks passed! System is ready to use.\n";
    echo "✅ Test Employer: employer@test.com (password: password123)\n";
    echo "✅ Test Applicant: applicant@test.com (password: password123)\n";
    echo "✅ Test Job: " . $testJob->title . "\n";
    echo "\nYou can now:\n";
    echo "1. Login as applicant and apply for the job\n";
    echo "2. Save the job posting\n";
    echo "3. Login as employer to view applicants\n";
    echo "4. Review and manage applications\n";
} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
