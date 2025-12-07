<?php

// Set up Laravel
define('LARAVEL_START', microtime(true));

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get companies with logos
$companies = \App\Models\Company::where('logo_path', '!=', null)->get(['id', 'name', 'logo_path']);

echo "Companies with logos:\n";
foreach ($companies as $company) {
    echo "ID: {$company->id}, Name: {$company->name}, Logo Path: {$company->logo_path}\n";
}

// Check if files exist
echo "\nChecking file existence:\n";
foreach ($companies as $company) {
    $path = 'storage/app/public/' . $company->logo_path;
    $exists = file_exists(__DIR__ . '/' . $path);
    echo "{$company->logo_path}: " . ($exists ? "EXISTS" : "NOT FOUND") . "\n";
}
