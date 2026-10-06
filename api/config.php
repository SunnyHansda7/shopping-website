<?php

$conn = mysqli_init();

mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

mysqli_real_connect(
    $conn,
    getenv("DB_HOST"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_NAME"),
    18007,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$conn) {
    die("Could not connect database: " . mysqli_connect_error());
}
?>
