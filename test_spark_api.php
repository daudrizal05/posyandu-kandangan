<?php
$ch = curl_init('http://localhost:8080/api/admin/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP Status: " . $code . "\n";
