<?php
$endpoints = ['dashboard', 'posyandu', 'balita', 'pengukuran', 'lansia', 'berita', 'galeri', 'infografis', 'dokumen', 'halaman_statis', 'pesan', 'user'];
foreach ($endpoints as $ep) {
    echo "Testing " . $ep . "\n";
    $ch = curl_init('http://localhost:8080/index.php/api/admin/' . $ep);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "HTTP Status: " . $code . "\n";
    if ($code !== 200 && $code !== 401) {
        echo substr($response, 0, 500) . "\n";
    }
}
