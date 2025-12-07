<?php

use App\Models\User;
use App\Models\Job;
use App\Models\Company;
use App\Models\Category;
use App\Models\SavedJob;
use App\Models\JobApplication;

// Check if controllers exist
echo "Checking system components...\n";
echo "✅ SavedJobController: " . (class_exists(\App\Http\Controllers\SavedJobController::class) ? "OK" : "MISSING") . "\n";
echo "✅ JobApplicationController: " . (class_exists(\App\Http\Controllers\JobApplicationController::class) ? "OK" : "MISSING") . "\n";

// Check models
echo "\nChecking models...\n";
echo "✅ SavedJob: " . (class_exists(SavedJob::class) ? "OK" : "MISSING") . "\n";
echo "✅ JobApplication: " . (class_exists(JobApplication::class) ? "OK" : "MISSING") . "\n";

// Check if test users exist, create if not
echo "\nSetting up test data...\n";

$testApplicant = User::where('email', 'applicant@test.com')->first();
if (!$testApplicant) {
    $testApplicant = User::create([
        'name' => 'Jamerick Evora',
        'email' => 'applicant@test.com',
        'password' => bcrypt('password'),
        'role' => 'applicant',
        'is_applicant' => true,
        'email_verified_at' => now(),
        'contact_number' => '+63 9455475804',
        'location' => 'Central Luzon',
        'skills' => 'PHP,Laravel,JavaScript,React',
        'bio' => 'Experienced full-stack developer'
    ]);
    echo "✅ Created test applicant: {$testApplicant->email}\n";
} else {
    echo "✅ Test applicant exists: {$testApplicant->email}\n";
}

$testEmployer = User::where('email', 'employer@test.com')->first();
if (!$testEmployer) {
    $testEmployer = User::create([
        'name' => 'Test Employer',
        'email' => 'employer@test.com',
        'password' => bcrypt('password'),
        'role' => 'employer',
        'is_employer' => true,
        'email_verified_at' => now(),
        'company_id' => null
    ]);

    // Create company
    $company = Company::create([
        'user_id' => $testEmployer->id,
        'name' => 'OmniQuest, Inc.',
        'description' => 'A leading financial services company',
        'industry' => 'Finance',
        'employee_count' => '100-500'
    ]);
    $testEmployer->update(['company_id' => $company->id]);
    echo "✅ Created test employer: {$testEmployer->email}\n";
} else {
    echo "✅ Test employer exists: {$testEmployer->email}\n";
}

// Create test job
$category = Category::first() ?? Category::create(['name' => 'Finance', 'slug' => 'finance']);
$testJob = Job::where('title', 'Accounts Payable Associate')
    ->where('company_id', $testEmployer->company->id)
    ->first();

if (!$testJob) {
    $testJob = Job::create([
        'company_id' => $testEmployer->company->id,
        'category_id' => $category->id,
        'title' => 'Accounts Payable Associate',
        'description' => 'We are seeking an experienced Accounts Payable Associate...',
        'location' => 'Central Luzon',
        'job_type' => 'full-time',
        'experience_level' => 'entry',
        'salary_min' => 25000,
        'salary_max' => 45000,
        'currency' => 'PHP',
        'status' => 'published',
        'published_at' => now(),
    ]);
    echo "✅ Created test job: {$testJob->title}\n";
} else {
    echo "✅ Test job exists: {$testJob->title}\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "✅ SYSTEM READY FOR TESTING\n";
echo str_repeat("=", 60) . "\n";
echo "\nTest Credentials:\n";
echo "Applicant Email: applicant@test.com\n";
echo "Applicant Password: password\n";
echo "Employer Email: employer@test.com\n";
echo "Employer Password: password\n";
echo "\nTest Job: " . $testJob->title . "\n";
echo "Test Company: " . $testEmployer->company->name . "\n";
