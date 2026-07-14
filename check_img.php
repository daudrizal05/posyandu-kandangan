<?php
$dir = 'C:\Users\HP\.gemini\antigravity-ide\brain\aeb80555-e54f-44ad-b2a3-3dbfdd53592c\.tempmediaStorage';
$files = scandir($dir);
foreach ($files as $file) {
    if (strpos($file, '.png') !== false || strpos($file, '.webp') !== false) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        $size = getimagesize($path);
        if ($size) {
            echo "$file => {$size[0]}x{$size[1]} (Size: " . filesize($path) . " bytes)\n";
        }
    }
}
