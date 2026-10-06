<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT c.id as cart_id, c.quantity, p.id as product_id, p.product_name, p.product_price, p.product_image 
        FROM user_cart c 
        JOIN product p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$total_cart_value = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a href="#"><img src="img/logo.png" class="logo" alt="Logo" height="40"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="cart.php">Cart</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Your Shopping Cart</h2>
        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        $item_total = $row['product_price'] * $row['quantity'];
                        $total_cart_value += $item_total;
                    ?>
                    <tr>
                        <td><img src="<?php echo $row['product_image']; ?>" height="80" alt=""></td>
                        <td class="align-middle"><?php echo $row['product_name']; ?></td>
                        <td class="align-middle">₹<?php echo number_format($row['product_price']); ?></td>
                        <td class="align-middle"><?php echo $row['quantity']; ?></td>
                        <td class="align-middle">₹<?php echo number_format($item_total); ?></td>
                        <td class="align-middle">
                            <a href="order.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-success">Buy Now</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="text-right mt-3">
            <h4>Total Cart Value: ₹<?php echo number_format($total_cart_value); ?></h4>
            <a href="index.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</body>
</html>
