<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Debug route to see if we can even boot PHP on Vercel
if ($path === '/debug') {
    echo "<h1>Debug Route Loaded!</h1>";
    echo "Current directory: " . getcwd() . "<br>";
    echo "__DIR__: " . __DIR__ . "<br>";
    
    echo "<h2>Files in " . dirname(__DIR__) . "/app:</h2>";
    $appDir = dirname(__DIR__) . '/app';
    if (is_dir($appDir)) {
        echo "<pre>";
        print_r(scandir($appDir));
        echo "</pre>";
    } else {
        echo "<b>APP DIRECTORY NOT FOUND! includeFiles failed!</b>";
    }
    exit;
}

// Ensure app/ exists
$appDir = dirname(__DIR__) . '/app';
if (!is_dir($appDir)) {
    http_response_code(200); // 200 so Vercel doesn't block it
    echo "<h2>FATAL ERROR:</h2> app/ directory not found in serverless function bundle! Vercel did not package the app folder.";
    exit;
}

chdir($appDir);

if ($path === '/') {
    require $appDir . '/index.php';
    exit;
}

if (preg_match('/\.php$/', $path)) {
    $apiFile = $appDir . $path;
    if (file_exists($apiFile)) {
        require $apiFile;
        exit;
    } else {
        http_response_code(404);
        echo "404 Not Found: " . $path;
        exit;
    }
}

http_response_code(404);
echo "404 Not Found";
?>
