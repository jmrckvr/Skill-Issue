<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$request = \Illuminate\Http\Request::create('/test');
$response = $kernel->handle($request);

$job_id = 144;
$application_id = 1;

echo "Route test:\n";
echo "Route name: employer.applicants.approve\n";
echo "Expected URL: /employer/jobs/144/applications/1/approve\n";
echo "Actual URL: " . route('employer.applicants.approve', ['job' => $job_id, 'application' => $application_id]) . "\n";
