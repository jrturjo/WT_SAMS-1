<?php
chdir(dirname(__DIR__));

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$path = trim($path, '/');

if (strpos($path, 'api/index.php') === 0) {
    $path = substr($path, strlen('api/index.php'));
    $path = ltrim($path, '/');
}

if ($path === 'index.php') {
    $_GET['url'] = $_GET['url'] ?? '';
} else {
    $_GET['url'] = $path;
}

require __DIR__ . '/../index.php';
