<?php

$url = 'https://upload.wikimedia.org/wikipedia/commons/e/e4/Lambang_Kabupaten_Ngawi.png';
$file = __DIR__ . '/public/img/logo.png';

$options = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"
    ]
];
$context = stream_context_create($options);

$content = @file_get_contents($url, false, $context);

if ($content === false) {
    echo "Gagal mendownload dari URL 1.\n";
    // Coba URL alternatif
    $url2 = 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/Lambang_Kabupaten_Ngawi.png/410px-Lambang_Kabupaten_Ngawi.png';
    $content = @file_get_contents($url2, false, $context);
    
    if ($content === false) {
        echo "Gagal mendownload dari URL 2.\n";
    } else {
        file_put_contents($file, $content);
        echo "Berhasil didownload dari URL 2!\n";
    }
} else {
    file_put_contents($file, $content);
    echo "Berhasil didownload dari URL 1!\n";
}

if (file_exists($file) && filesize($file) > 10000) {
    echo "File logo.png siap digunakan!\n";
} else {
    echo "File gagal atau rusak.\n";
}
