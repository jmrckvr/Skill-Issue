<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$connection = $app->make('db');
$result = $connection->table('job_applications')
    ->where('id', 1)
    ->first();

echo "Application ID 1 Status: " . ($result ? $result->status : 'Not found') . "\n";
if ($result) {
    echo "Full Details:\n";
    echo json_encode($result, JSON_PRETTY_PRINT);
}
