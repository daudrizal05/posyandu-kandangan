<?php
$dir = "C:/Users/HP/.gemini/antigravity-ide/brain/cd4868c5-e21d-41d1-8acd-e13b47fcaf95/.tempmediaStorage";
$files = glob($dir . "/*");
foreach($files as $file) {
  $size = @getimagesize($file);
  $stat = stat($file);
  if ($stat["mtime"] > strtotime("2026-07-06 13:00:00") || $stat["ctime"] > strtotime("2026-07-06 13:00:00")) {
      echo basename($file) . " - " . $size[0] . "x" . $size[1] . " - " . date("Y-m-d H:i:s", $stat["mtime"]) . "\n";
  }
}
?>
