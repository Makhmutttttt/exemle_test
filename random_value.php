<?php
require 'connect_db.php';

// Generate 40 random records
for ($i = 0; $i < 40; $i++) {
    $userName = generateRandomString(10);
    $email = generateRandomEmail();
    $homepage = generateRandomURL();
    $text = generateRandomString(50);
    $ipAddress = generateRandomIP();
    $browser = generateRandomString(20);
    $createdAt = date('Y-m-d H:i:s');

    $stmt = $database->prepare("INSERT INTO guestbook (user_name, email, homepage, text, ip_address, browser, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userName, $email, $homepage, $text, $ipAddress, $browser, $createdAt]);
}

echo "Records inserted successfully.";

// Function to generate a random string
function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Function to generate a random email
function generateRandomEmail() {
    $email = generateRandomString(5) . '@example.com';
    return $email;
}

// Function to generate a random URL
function generateRandomURL() {
    $url = 'http://www.' . generateRandomString(10) . '.com';
    return $url;
}

// Function to generate a random IP address
function generateRandomIP() {
    $ip = rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
    return $ip;
}
?>