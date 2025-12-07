<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::find(28);
echo "User: " . $user->email . "\n";
echo "Password hash: " . $user->password . "\n";
echo "Password is hashed: " . (strlen($user->password) > 20 ? 'YES' : 'NO') . "\n";

// Check if a test password hashes correctly
$testPassword = 'password';
echo "\n\nPassword verification test:\n";
echo "Test password 'password' matches: " . (password_verify($testPassword, $user->password) ? 'YES' : 'NO') . "\n";
