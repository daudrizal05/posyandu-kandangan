<?php
$ch = curl_init('http://localhost:8080/index.php/api/admin/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
echo $response;
