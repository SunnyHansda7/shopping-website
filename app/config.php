<?php

$host = getenv("DB_HOST") ?: "localhost";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASS") ?: "Password123!";
$db = getenv("DB_NAME") ?: "shopping";
$port = getenv("DB_PORT") ? (int) getenv("DB_PORT") : 3306;

$conn = mysqli_init();

// If DB_USE_SSL is set to "true" or the port is 18007 (often used by cloud DBs requiring SSL), use SSL.
if (getenv("DB_USE_SSL") === "true" || $port === 18007) {
    mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
    $flags = MYSQLI_CLIENT_SSL;
} else {
    $flags = 0;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    if (
        !mysqli_real_connect(
            $conn,
            $host,
            $user,
            $pass,
            $db,
            $port,
            NULL,
            $flags
        )
    ) {
        die("Database connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    http_response_code(200); // Force 200 so Vercel doesn't hide the error screen
    die("Database Connection Error: " . $e->getMessage() . "<br><br>Please check your Aiven credentials and Vercel Environment Variables.");
}

mysqli_set_charset($conn, "utf8mb4");
?>