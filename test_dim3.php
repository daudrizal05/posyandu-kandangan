<?php
$files = [
    "C:/Users/HP/.gemini/antigravity-ide/brain/cd4868c5-e21d-41d1-8acd-e13b47fcaf95/media__1783326169392.png",
    "C:/Users/HP/.gemini/antigravity-ide/brain/cd4868c5-e21d-41d1-8acd-e13b47fcaf95/media__1783326159845.png",
    "C:/Users/HP/.gemini/antigravity-ide/brain/cd4868c5-e21d-41d1-8acd-e13b47fcaf95/media__1783325960511.png",
    "C:/Users/HP/.gemini/antigravity-ide/brain/cd4868c5-e21d-41d1-8acd-e13b47fcaf95/media__1783326166358.jpg"
];
foreach($files as $file) {
  $size = @getimagesize($file);
  echo basename($file) . " - " . $size[0] . "x" . $size[1] . "\n";
}
?>
