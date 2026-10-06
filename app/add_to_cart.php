<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    // Check if product is already in cart
    $check_stmt = mysqli_prepare($conn, "SELECT id, quantity FROM user_cart WHERE user_id = ? AND product_id = ?");
    mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Update quantity
        $new_qty = $row['quantity'] + 1;
        $update_stmt = mysqli_prepare($conn, "UPDATE user_cart SET quantity = ? WHERE id = ?");
        mysqli_stmt_bind_param($update_stmt, "ii", $new_qty, $row['id']);
        mysqli_stmt_execute($update_stmt);
    } else {
        // Insert new
        $insert_stmt = mysqli_prepare($conn, "INSERT INTO user_cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($insert_stmt);
    }
    header("Location: cart.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
