<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-md bg-secondary navbar-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="add.php">Add Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="admin_manage_sellers.php">Manage Sellers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">Logout (<?php echo $_SESSION['admin_username']; ?>)</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Welcome to Admin Dashboard, <?php echo $_SESSION['admin_username']; ?>!</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h4 class="card-title">Manage Products</h4>
                        <p class="card-text">Add new products to your store.</p>
                        <a href="add.php" class="btn btn-warning">Go to Add Product</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h4 class="card-title">Manage Sellers</h4>
                        <p class="card-text">Approve or reject seller applications.</p>
                        <a href="admin_manage_sellers.php" class="btn btn-warning">Go to Manage Sellers</a>
                    </div>
                </div>
            </div>
            <!-- More admin features can be added here -->
        </div>
    </div>
</body>
</html>
