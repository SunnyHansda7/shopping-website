<?php
session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: seller_login.php");
    exit();
}
include("config.php");

if(isset($_POST['submit'])){
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $seller_id = $_SESSION['seller_id'];
    
    // Instead of local upload which fails on serverless/Vercel, we will just use a dummy image or allow URL input
    // To keep it simple and working for local dev, we use file upload
    if(isset($_FILES['product_image']) && $_FILES['product_image']['name'] != ''){
        $img = $_FILES['product_image']['name'];
        $tmp = $_FILES['product_image']['tmp_name'];
        $folder = "image/" . basename($img);
        
        if (!is_dir('image')) {
            mkdir('image', 0777, true);
        }
        
        move_uploaded_file($tmp, $folder);
    } else {
        $folder = "https://dummyimage.com/300x300/ccc/000&text=No+Image";
    }

    $sql = "INSERT INTO product(product_name, product_price, product_image, category, seller_id) VALUES ('$product_name', '$product_price', '$folder', '$category', '$seller_id')";
    
    if(mysqli_query($conn, $sql)){
        header("Location: seller_dashboard.php?msg=added");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="mb-4 text-center">Add New Product</h3>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Product Price (₹)</label>
                                <input type="number" name="product_price" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" class="form-control" required>
                                    <option value="General">General</option>
                                    <option value="Men's Clothing">Men's Clothing</option>
                                    <option value="Women's Clothing">Women's Clothing</option>
                                    <option value="Laptops">Laptops</option>
                                    <option value="Mobiles">Mobiles</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Image</label>
                                <input type="file" name="product_image" class="form-control-file" accept="image/*">
                                <small class="text-muted">Local file upload might not persist in cloud environments.</small>
                            </div>
                            <button type="submit" name="submit" class="btn btn-warning btn-block mt-4">Add Product</button>
                            <a href="seller_dashboard.php" class="btn btn-link btn-block">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
