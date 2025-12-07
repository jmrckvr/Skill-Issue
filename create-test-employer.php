<?php

// Simulate employer registration
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

try {
    echo "🚀 Creating test employer account...\n\n";

    // Create employer user
    $employer = User::create([
        'name' => 'Test Employer',
        'email' => 'employer@test.com',
        'password' => Hash::make('password123'),
        'role' => 'employer',
        'email_verified_at' => now(),
        'is_active' => true,
    ]);

    echo "✅ User created:\n";
    echo "   Name: {$employer->name}\n";
    echo "   Email: {$employer->email}\n";
    echo "   Role: {$employer->role}\n";
    echo "   ID: {$employer->id}\n\n";

    // Create company
    $company = Company::create([
        'user_id' => $employer->id,
        'name' => 'Test Company Inc.',
        'email' => 'hr@testcompany.com',
        'phone' => '+63 555-1234',
        'website' => 'https://testcompany.com',
        'description' => 'A test company for employer registration',
        'city' => 'Manila',
        'country' => 'Philippines',
        'industry' => 'Technology',
        'is_verified' => false,
        'state' => null,
    ]);

    echo "✅ Company created:\n";
    echo "   Name: {$company->name}\n";
    echo "   Email: {$company->email}\n";
    echo "   Location: {$company->city}, {$company->country}\n";
    echo "   Industry: {$company->industry}\n";
    echo "   ID: {$company->id}\n\n";

    // Verify relationship
    $user = User::with('company')->find($employer->id);
    echo "✅ Relationship verified:\n";
    echo "   User has company: " . ($user->company ? 'Yes' : 'No') . "\n";
    echo "   Company name: {$user->company->name}\n\n";

    // Check roles and permissions
    echo "✅ Role verification:\n";
    echo "   User role: {$user->role}\n";
    echo "   Is employer: " . ($user->role === 'employer' ? 'Yes ✓' : 'No ✗') . "\n\n";

    echo "🎉 Employer account test completed successfully!\n";
    echo "📊 You can now:\n";
    echo "   1. Login with: employer@test.com / password123\n";
    echo "   2. Access dashboard at: /employer/dashboard\n";
    echo "   3. Create jobs and manage applicants\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}
