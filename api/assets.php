<?php
$file = $_GET['file'] ?? '';
$base = dirname(__DIR__);
$path = realpath($base . '/' . ltrim($file, '/'));

$basePath = realpath($base) . DIRECTORY_SEPARATOR;
if ($path === false || strpos($path, $basePath) !== 0 || !is_file($path)) {
    http_response_code(404);
    exit('Not found');
}

$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
$types = [
    'css'   => 'text/css; charset=UTF-8',
    'js'    => 'application/javascript; charset=UTF-8',
    'jpg'   => 'image/jpeg',
    'jpeg'  => 'image/jpeg',
    'png'   => 'image/png',
    'gif'   => 'image/gif',
    'svg'   => 'image/svg+xml',
    'webp'  => 'image/webp',
    'ico'   => 'image/x-icon',
    'txt'   => 'text/plain; charset=UTF-8',
];
header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
readfile($path);