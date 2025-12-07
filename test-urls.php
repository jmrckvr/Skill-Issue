<?php
// Test what URLs are being generated
$baseUrl = 'http://127.0.0.1:8000';

$testPaths = [
    'logos/acme-tech.svg' => $baseUrl . '/logos/acme-tech.svg',
    'logos/eduplus.jpg' => $baseUrl . '/logos/eduplus.jpg',
    'logos/startuphub.jpg' => $baseUrl . '/logos/startuphub.jpg',
];

echo "Testing Logo URLs:\n";
echo "==================\n\n";

foreach ($testPaths as $logoPath => $fullUrl) {
    echo "Path: $logoPath\n";
    echo "Full URL: $fullUrl\n";

    // Check if file exists in public folder
    $publicPath = __DIR__ . '/public/' . $logoPath;
    $exists = file_exists($publicPath);
    echo "File exists: " . ($exists ? "YES" : "NO") . "\n";
    echo "---\n";
}

// Also test with asset() helper to see how it resolves
echo "\nNote: asset() helper in Laravel resolves paths like:\n";
echo "asset('logos/file.jpg') -> /logos/file.jpg\n";
echo "asset('storage/logos/file.jpg') -> /storage/logos/file.jpg\n";
