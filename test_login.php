<?php
// Test script untuk login dan akses materi_tugas

$login_url = 'http://localhost:8080/auth/login';
$materi_tugas_url = 'http://localhost:8080/siswa/materi_tugas';

// Data login
$login_data = [
    'username' => 'sura',
    'password' => 'siswa123',
    'csrf_test_name' => 'test_csrf'
];

echo "Testing login dan akses materi_tugas...\n";

// Step 1: Get CSRF token dari halaman login
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8080/auth');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
curl_close($ch);

// Extract CSRF token
if (preg_match('/name="csrf_test_name" value="([^"]+)"/', $response, $matches)) {
    $csrf_token = $matches[1];
    echo "CSRF Token: $csrf_token\n";
    
    // Step 2: Login
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $login_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'username' => 'sura',
        'password' => 'siswa123',
        'csrf_test_name' => $csrf_token
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    $response = curl_exec($ch);
    curl_close($ch);
    
    echo "Login response length: " . strlen($response) . "\n";
    
    // Step 3: Akses materi_tugas
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $materi_tugas_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "Materi Tugas HTTP Code: $http_code\n";
    echo "Response length: " . strlen($response) . "\n";
    
    if ($http_code == 200) {
        echo "SUCCESS: Materi Tugas page loaded!\n";
        if (strpos($response, 'Materi & Tugas') !== false) {
            echo "SUCCESS: Page contains 'Materi & Tugas' text\n";
        } else {
            echo "WARNING: Page doesn't contain expected text\n";
        }
    } else {
        echo "ERROR: Failed to load Materi Tugas page\n";
    }
    
} else {
    echo "ERROR: Could not extract CSRF token\n";
}

// Clean up
if (file_exists('cookies.txt')) {
    unlink('cookies.txt');
}
?> 