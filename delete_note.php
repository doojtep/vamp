<?php
if (isset($_POST['index'])) {
  $filename = "notes.txt";
  $lines = file($filename, FILE_IGNORE_NEW_LINES);
  $index = (int)$_POST['index'];

  $parts = explode("|||", $lines[$index]);
  if (isset($parts[2]) && trim($parts[2]) === "1") {
    echo "locked";
    exit;
  }

  unset($lines[$index]);
  file_put_contents($filename, implode("\n", $lines));
  echo "deleted";
}
?>
