<?php
$dir = "C:/Users/HP/.gemini/antigravity-ide/brain/cd4868c5-e21d-41d1-8acd-e13b47fcaf95";
$files = glob($dir . "/media__*.png");
foreach($files as $file) {
  $size = @getimagesize($file);
  echo basename($file) . " - " . $size[0] . "x" . $size[1] . " - " . filesize($file) . "\n";
}
?>
