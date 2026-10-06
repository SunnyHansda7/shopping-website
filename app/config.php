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

mysqli_set_charset($conn, "utf8mb4");
?>