<?php
session_start();
include("config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Add to recently viewed
    if (!isset($_SESSION['recently_viewed'])) {
        $_SESSION['recently_viewed'] = [];
    }
    // Remove if already in array to move it to the top
    if (($key = array_search($id, $_SESSION['recently_viewed'])) !== false) {
        unset($_SESSION['recently_viewed'][$key]);
    }
    array_unshift($_SESSION['recently_viewed'], $id);
    
    // Limit to last 4 products
    if (count($_SESSION['recently_viewed']) > 4) {
        array_pop($_SESSION['recently_viewed']);
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM product WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['product_name']; ?> - Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $row['product_image']; ?>" class="img-fluid" alt="">
            </div>
            <div class="col-md-6 mt-4">
                <h2><?php echo $row['product_name']; ?></h2>
                <h4 class="text-secondary">Category: <?php echo $row['category']; ?></h4>
                <h3 class="text-danger">₹<?php echo number_format($row['product_price']); ?></h3>
                <p class="mt-4">This is a great product. Grab it before it goes out of stock!</p>
                <?php
                    $category_details = "<ul><li>Premium Quality</li><li>Durable Material</li><li>1 Year Warranty</li></ul>";
                    if ($row['category'] == 'Mobiles') {
                        $category_details = "<ul><li>Latest Processor</li><li>High Resolution Camera</li><li>Long Lasting Battery</li><li>1 Year Warranty</li></ul>";
                    } elseif ($row['category'] == 'Laptops') {
                        $category_details = "<ul><li>High Performance CPU</li><li>Ample RAM & Storage</li><li>Crisp HD Display</li><li>1 Year Warranty</li></ul>";
                    } elseif (strpos($row['category'], 'Clothing') !== false) {
                        $category_details = "<ul><li>Comfortable Fit</li><li>High Quality Fabric</li><li>Machine Washable</li><li>Easy Returns</li></ul>";
                    }
                ?>
                <div class="mt-4 mb-4">
                    <h5>Key Features:</h5>
                    <?php echo $category_details; ?>
                    <p class="text-success"><small>✓ 100% Original Product<br>✓ Pay on delivery might be available</small></p>
                </div>
                <div class="mt-4">
                    <a class="btn btn-danger btn-lg" href="order.php?id=<?php echo $row['id'];?>">Buy Now</a>
                    <a class="btn btn-info btn-lg" href="add_to_cart.php?id=<?php echo $row['id'];?>">Add to Cart</a>
                    <a class="btn btn-secondary btn-lg" href="index.php">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        echo "Product not found.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
