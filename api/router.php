<?php
// Router specifically for Vercel deployment

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);



// Enable error reporting to debug Vercel 500 errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Change directory to the app folder so that relative includes like include("config.php") work properly.
chdir(dirname(__DIR__) . '/app');

// 1. Rewrite root to /app/index.php
if ($path === '/') {
    require dirname(__DIR__) . '/app/index.php';
    exit;
}

// 2. Rewrite any .php file to /app/filename.php
if (preg_match('/\.php$/', $path)) {
    $apiFile = dirname(__DIR__) . '/app' . $path;
    if (file_exists($apiFile)) {
        require $apiFile;
        exit;
    }
}

// 3. Otherwise, look for static files in the /public directory
$publicFile = dirname(__DIR__) . '/public' . $path;
if (file_exists($publicFile) && !is_dir($publicFile)) {
    $ext = pathinfo($publicFile, PATHINFO_EXTENSION);
    $mime = 'text/plain';
    if ($ext === 'css') $mime = 'text/css';
    if ($ext === 'js') $mime = 'application/javascript';
    if ($ext === 'png') $mime = 'image/png';
    if ($ext === 'jpg' || $ext === 'jpeg') $mime = 'image/jpeg';
    
    header("Content-Type: $mime");
    readfile($publicFile);
    exit;
}

// 4. Not Found Fallback
http_response_code(404);
echo "404 Not Found";
