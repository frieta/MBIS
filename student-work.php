<?php
$studentDir = __DIR__ . '/student_works';
$files = [];

if (is_dir($studentDir)) {
  $all = scandir($studentDir);
  foreach ($all as $f) {
    if ($f === '.' || $f === '..') continue;
    if (is_file($studentDir . '/' . $f) && preg_match('/\.html?$/i', $f)) {
      $files[] = $f;
    }
  }
  sort($files, SORT_NATURAL | SORT_FLAG_CASE);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id < 1 || $id > count($files)) {
  http_response_code(404);
  echo 'Student work not found.';
  exit;
}

$selected = $files[$id - 1];
$fullPath = realpath($studentDir . '/' . $selected);
$basePath = realpath($studentDir);

if ($fullPath === false || $basePath === false || strpos($fullPath, $basePath) !== 0 || !is_file($fullPath)) {
  http_response_code(404);
  echo 'Student work not found.';
  exit;
}

header('Content-Type: text/html; charset=UTF-8');
readfile($fullPath);
