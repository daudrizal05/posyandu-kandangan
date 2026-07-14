<?php

// Bootstrap CI4
define('FCPATH', __DIR__ . '/public/');
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/codeigniter4/framework/system/Boot.php';

// Langsung pakai pg_connect
$host     = 'localhost';
$port     = '5432';
$dbname   = 'db_estunting';
$user     = 'postgres';
$password = 'admin123';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Gagal konek ke database\n");
}

// Lihat semua user
$result = pg_query($conn, "SELECT id, name, username, role, is_active FROM users ORDER BY id");
echo "=== DATA USER SAAT INI ===\n";
while ($row = pg_fetch_assoc($result)) {
    echo "ID: {$row['id']} | Username: {$row['username']} | Role: {$row['role']} | Aktif: {$row['is_active']}\n";
}

// Hash untuk password 'admin123'
$newHash = password_hash('admin123', PASSWORD_DEFAULT);

// Update atau insert user admin
$check = pg_query($conn, "SELECT id FROM users WHERE username = 'admin'");
if (pg_num_rows($check) > 0) {
    // Update password user admin
    $row = pg_fetch_assoc($check);
    $sql = "UPDATE users SET password = '$newHash', is_active = true WHERE username = 'admin'";
    pg_query($conn, $sql);
    echo "\n>>> Password user 'admin' diperbarui menjadi 'admin123'\n";
} else {
    // Insert user admin baru
    $now = date('Y-m-d H:i:s');
    $sql = "INSERT INTO users (name, email, username, password, role, is_active, created_at, updated_at)
            VALUES ('Administrator', 'admin@siposka.com', 'admin', '$newHash', 'superadmin', true, '$now', '$now')";
    pg_query($conn, $sql);
    echo "\n>>> User 'admin' baru berhasil dibuat dengan password 'admin123'\n";
}

// Update juga superadmin
$supCheck = pg_query($conn, "SELECT id FROM users WHERE username = 'superadmin'");
if (pg_num_rows($supCheck) > 0) {
    pg_query($conn, "UPDATE users SET password = '$newHash', is_active = true WHERE username = 'superadmin'");
    echo ">>> Password 'superadmin' diperbarui menjadi 'admin123'\n";
}

// Tampilkan user final
echo "\n=== DATA USER SETELAH UPDATE ===\n";
$result2 = pg_query($conn, "SELECT id, name, username, role, is_active FROM users ORDER BY id");
while ($row = pg_fetch_assoc($result2)) {
    echo "ID: {$row['id']} | Username: {$row['username']} | Role: {$row['role']} | Aktif: {$row['is_active']}\n";
}

pg_close($conn);
echo "\nSelesai!\n";
