<?php

$dir_func = "/functions/";
$function_files = [
  $dir_func . 'config.php',
  $dir_func . 'init.php',
  $dir_func . 'func.php',
  $dir_func . 'block.php',
];

foreach ($function_files as $file) {
  if ((file_exists(__DIR__ . $file))) {
    locate_template($file, true, true);
  } else {
    trigger_error("`$file`ファイルが見つかりません", E_USER_ERROR);
  }
}
