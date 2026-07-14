<?php
$dir = "C:/Users/HP/.gemini/antigravity-ide/brain/cd4868c5-e21d-41d1-8acd-e13b47fcaf95/.tempmediaStorage";
$files = glob($dir . "/*");
foreach($files as $file) {
  $size = @getimagesize($file);
  if ($size && $size[0] != 1920) {
    echo basename($file) . " - " . $size[0] . "x" . $size[1] . " - " . filesize($file) . " bytes\n";
  }
}
?>
