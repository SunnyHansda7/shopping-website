<?php
// Display all errors directly to the screen
error_reporting(E_ALL);
ini_set('display_errors', 1);
http_response_code(200); // Force 200 OK so Vercel doesn't hide the error

echo "<h1>Database Connection Test</h1>";
echo "Checking environment variables...<br>";
echo "DB_HOST: " . (getenv("DB_HOST") ? "SET" : "NOT SET") . "<br>";
echo "DB_USER: " . (getenv("DB_USER") ? "SET" : "NOT SET") . "<br>";
echo "DB_NAME: " . (getenv("DB_NAME") ? "SET" : "NOT SET") . "<br>";
echo "DB_PORT: " . (getenv("DB_PORT") ? getenv("DB_PORT") : "NOT SET (Default 3306)") . "<br>";
echo "DB_USE_SSL: " . (getenv("DB_USE_SSL") ? getenv("DB_USE_SSL") : "NOT SET") . "<br><br>";

echo "Attempting to connect to the database...<br>";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $host = getenv("DB_HOST") ?: "localhost";
    $user = getenv("DB_USER") ?: "root";
    $pass = getenv("DB_PASS") ?: "Password123!";
    $db = getenv("DB_NAME") ?: "shopping";
    $port = getenv("DB_PORT") ? (int) getenv("DB_PORT") : 3306;

    $conn = mysqli_init();

    if (getenv("DB_USE_SSL") === "true" || $port === 18007) {
        mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
        $flags = MYSQLI_CLIENT_SSL;
        echo "SSL is ENABLED.<br>";
    } else {
        $flags = 0;
        echo "SSL is DISABLED.<br>";
    }

    if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, $flags)) {
        echo "<b style='color:red;'>Connection Failed: " . mysqli_connect_error() . "</b>";
    } else {
        echo "<b style='color:green;'>SUCCESS! Successfully connected to Aiven Database!</b>";
    }

} catch (Exception $e) {
    echo "<b style='color:red;'>EXCEPTION CAUGHT: " . $e->getMessage() . "</b>";
}
?>
