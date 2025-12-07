<?php
// Map companies to their logos
$dbPath = __DIR__ . '/database/database.sqlite';

if (!file_exists($dbPath)) {
    die("Database not found");
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mapping based on company names (case-insensitive)
    $logoMapping = [
        1 => 'acme-tech.svg',           // ACME Tech Solutions
        2 => 'global-finance.jpg',      // Global Finance PH
        3 => 'philhealth.jpg',          // PhilHealth Solutions
        4 => 'retailco.jpg',            // RetailCo Philippines
        5 => 'startuphub.jpg',          // StartupHub Asia (ConstructionPro)
        6 => 'startuphub.jpg',          // StartupHub Asia (duplicate)
        7 => 'infotech.jpg',            // Infotech Innovations
        8 => 'medicare.jpg',            // MediCare Services
        9 => 'eduplus.jpg',             // EduPlus Learning Systems
        10 => 'logistics.jpg',          // Logistics Express PH
    ];

    // Update companies with logo paths
    foreach ($logoMapping as $companyId => $logoFile) {
        $logoPath = 'logos/' . $logoFile;
        $stmt = $pdo->prepare("UPDATE companies SET logo_path = ? WHERE id = ?");
        $stmt->execute([$logoPath, $companyId]);
    }

    echo "✓ Updated " . count($logoMapping) . " companies with logos\n";

    // Verify
    $stmt = $pdo->query("SELECT id, name, logo_path FROM companies ORDER BY id");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\n=== Updated Companies ===\n";
    foreach ($results as $company) {
        echo $company['id'] . ": " . $company['name'] . " -> " . ($company['logo_path'] ?? 'NULL') . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
