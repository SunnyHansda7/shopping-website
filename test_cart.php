<?php
include("api/config.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user_id = 1; // Assuming a user exists
$product_id = 1;

$insert_stmt = mysqli_prepare($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
if (!$insert_stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $product_id);
if (!mysqli_stmt_execute($insert_stmt)) {
    die("Execute failed: " . mysqli_error($conn));
}

echo "Inserted successfully. Cart contents:\n";
$res = mysqli_query($conn, "SELECT * FROM cart");
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
