<?php
// Mock HTTP request
$url = 'http://localhost:8080/api/admin/dashboard';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
echo $response;
