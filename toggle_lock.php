<?php
if (isset($_POST['index'])) {
  $filename = "notes.txt";
  $lines = file($filename, FILE_IGNORE_NEW_LINES);
  $index = (int)$_POST['index'];

  $parts = explode("|||", $lines[$index]);
  $parts[2] = (isset($parts[2]) && trim($parts[2]) === "1") ? "0" : "1";
  $lines[$index] = implode("|||", $parts);

  file_put_contents($filename, implode("\n", $lines));
  echo $parts[2]; // 0 หรือ 1
}
?>
