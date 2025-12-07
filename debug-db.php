<?php
// Check all companies
$dbPath = __DIR__ . '/database/database.sqlite';

if (!file_exists($dbPath)) {
    die("Database not found at: $dbPath");
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check all companies
    $stmt = $pdo->query("SELECT id, name, logo_path FROM companies LIMIT 15");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "=== All Companies (First 15) ===\n\n";
    foreach ($results as $company) {
        echo "ID: " . $company['id'] . " | Name: " . $company['name'] . " | Logo: " . ($company['logo_path'] ?? "NULL") . "\n";
    }

    echo "\n=== Database Stats ===\n";
    $countStmt = $pdo->query("SELECT COUNT(*) as total FROM companies");
    $count = $countStmt->fetch(PDO::FETCH_ASSOC);
    echo "Total companies: " . $count['total'] . "\n";

    $withLogoStmt = $pdo->query("SELECT COUNT(*) as total FROM companies WHERE logo_path IS NOT NULL");
    $withLogo = $withLogoStmt->fetch(PDO::FETCH_ASSOC);
    echo "Companies with logos: " . $withLogo['total'] . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
