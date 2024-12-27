<?php
require_once 'midtrans-php-master/Midtrans.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test server key (sandbox key from your details)
$server_key = 'SB-Mid-server-32GuoRuJNv-7Dto4awpnL7Ix';

// Print server key details
echo "Server Key Analysis:\n";
echo "Length: " . strlen($server_key) . "\n";
echo "Raw: " . $server_key . "\n";
echo "Base64 encoded: " . base64_encode($server_key) . "\n";

// Configure Midtrans
\Midtrans\Config::$serverKey = $server_key;
\Midtrans\Config::$isProduction = false; // Ensure sandbox mode
\Midtrans\Config::$isSanitized = true; // Optional for sanitization
\Midtrans\Config::$is3ds = true; // Optional for 3D Secure

// Create test transaction
// Create test transaction with payment_type
$transaction = array(
    'payment_type' => 'bank_transfer', // Tambahkan metode pembayaran
    'transaction_details' => array(
        'order_id' => 'TEST-' . time(),
        'gross_amount' => 10000 // Amount in IDR
    ),
    'customer_details' => array(
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'phone' => '081234567890'
    ),
    'bank_transfer' => array(
        'bank' => 'bca' // Jika memilih bank transfer, tambahkan bank yang digunakan
    )
);


// Test direct API call using cURL
// Test direct API call using cURL
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/charge",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($transaction),
    CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "authorization: Basic " . base64_encode($server_key . ':'),
        "content-type: application/json"
    ),
));

echo "\nTesting direct API call...\n";
$response = curl_exec($curl);
$err = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

echo "HTTP Code: " . $httpCode . "\n";
if ($err) {
    echo "cURL Error: " . $err . "\n";
} else {
    echo "Response: " . $response . "\n";
    echo "Decoded Response: " . print_r(json_decode($response, true), true) . "\n";
}

curl_close($curl);


// Try using Midtrans library
echo "\nTesting Midtrans library...\n";
try {
    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
    echo "Success! Token: " . $snapToken . "\n";
} catch (\Exception $e) {
    echo "Midtrans Error: " . $e->getMessage() . "\n";
}
