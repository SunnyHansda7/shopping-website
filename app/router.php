<?php
// Router specifically for Vercel deployment

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 1. Rewrite root to /api/index.php
if ($path === '/') {
    require __DIR__ . '/index.php';
    exit;
}

// 2. Rewrite any .php file to /api/filename.php
if (preg_match('/\.php$/', $path)) {
    $apiFile = __DIR__ . $path;
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
