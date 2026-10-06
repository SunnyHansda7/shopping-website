<?php
session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: seller_login.php");
    exit();
}
include("config.php");
$seller_id = $_SESSION['seller_id'];
$seller_name = $_SESSION['seller_name'];

// Fetch seller products
$sql = "SELECT * FROM product WHERE seller_id = $seller_id";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Seller Hub - <?php echo $seller_name; ?></a>
        <div class="ml-auto">
            <a href="seller_add_product.php" class="btn btn-warning mr-3">Add New Product</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="mb-4">Your Products</h3>
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
            <div class="alert alert-success">Product added successfully!</div>
        <?php endif; ?>
        
        <table class="table table-bordered table-striped bg-white">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="<?php echo $row['product_image']; ?>" height="50" style="object-fit: cover; width: 50px;"></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td>₹<?php echo number_format($row['product_price']); ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td>
                        <a href="details.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn btn-sm btn-info">View on Store</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if(mysqli_num_rows($result) == 0): ?>
                <tr><td colspan="6" class="text-center">You haven't added any products yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
