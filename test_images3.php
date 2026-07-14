<?php
$dir = "C:/Users/HP/.gemini/antigravity-ide/brain/cd4868c5-e21d-41d1-8acd-e13b47fcaf95/.tempmediaStorage";
$files = glob($dir . "/*");
foreach($files as $file) {
  $stat = stat($file);
  // check if modified in the last hour
  if (time() - $stat["mtime"] < 3600 || time() - $stat["ctime"] < 3600) {
    echo basename($file) . " - " . date("H:i:s", $stat["mtime"]) . " - " . filesize($file) . " bytes\n";
  }
}
?>
