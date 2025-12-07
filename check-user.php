<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::where('email', 'alamares@gmail.com')->first();
if ($user) {
    echo "User Found!\n";
    echo "ID: " . $user->id . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Created: " . $user->created_at . "\n";
} else {
    echo "User NOT found in database\n";
}

echo "\n\nAll recent users:\n";
$recentUsers = \App\Models\User::latest()->limit(5)->get();
foreach ($recentUsers as $u) {
    echo "- ID: {$u->id}, Email: {$u->email}, Created: {$u->created_at}\n";
}
