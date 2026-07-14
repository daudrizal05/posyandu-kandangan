<?php
// Buat dummy PNG 1x1 pixel transparan
$base64 = "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=";
$img = base64_decode($base64);
file_put_contents('public/assets/img/logo-ngawi.png', $img);
echo "Dummy logo created.";
