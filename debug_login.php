<?php
// Test script untuk debug login
$host     = 'localhost';
$port     = '5432';
$dbname   = 'db_estunting';
$user     = 'postgres';
$password = 'admin123';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) { die("DB gagal\n"); }

// Test user admin
$result = pg_query($conn, "SELECT id, username, password, role, is_active FROM users WHERE username = 'admin'");
$row = pg_fetch_assoc($result);
if (!$row) {
    die("User 'admin' TIDAK ADA di database!\n");
}

echo "User ditemukan:\n";
echo "  ID: " . $row['id'] . "\n";
echo "  Username: " . $row['username'] . "\n";
echo "  Role: " . $row['role'] . "\n";
echo "  is_active: " . $row['is_active'] . "\n";
echo "  Password hash: " . substr($row['password'], 0, 30) . "...\n\n";

// Test verifikasi password
$testPass = 'admin123';
$verified = password_verify($testPass, $row['password']);
echo "Test password_verify('admin123', hash) = " . ($verified ? "TRUE ✓" : "FALSE ✗") . "\n";

// Test is_active
$isActive = $row['is_active'];
echo "is_active value raw: '" . $isActive . "'\n";
echo "is_active == true: " . (($isActive == true) ? "TRUE" : "FALSE") . "\n";
echo "is_active === 't': " . (($isActive === 't') ? "TRUE" : "FALSE") . "\n";
echo "!is_active evaluates: " . (!$isActive ? "block (inactive)" : "ok (active)") . "\n";
