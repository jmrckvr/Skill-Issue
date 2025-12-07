<?php

// Test employer registration
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

try {
    echo "🔍 Checking employer registration...\n\n";

    // Check latest users
    $users = User::latest()->take(5)->get(['id', 'name', 'email', 'role', 'email_verified_at', 'created_at']);

    echo "📋 Latest 5 Users:\n";
    echo str_repeat("=", 80) . "\n";
    foreach ($users as $user) {
        echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email}\n";
        echo "Role: {$user->role} | Verified: " . ($user->email_verified_at ? 'Yes' : 'No') . "\n";
        echo "Created: {$user->created_at}\n";

        // Check if user has company
        $company = $user->company;
        if ($company) {
            echo "✅ Company: {$company->name} (ID: {$company->id})\n";
            echo "   Location: {$company->city}, {$company->country}\n";
        } else {
            echo "❌ No company associated\n";
        }
        echo str_repeat("-", 80) . "\n";
    }

    echo "\n✅ Test completed successfully!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
