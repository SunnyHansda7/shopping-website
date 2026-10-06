<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a href="index.php"><img src="img/logo.png" class="logo" alt="" height="40"></a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="cart.php">Cart</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Welcome, <?php echo $_SESSION['username']; ?></a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link text-white" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="register.php">Register</a></li>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-warning" href="#" id="sellerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Partner with Us
                    </a>
                    <div class="dropdown-menu" aria-labelledby="sellerDropdown">
                        <a class="dropdown-item" href="seller_apply.php">Become a Seller</a>
                        <a class="dropdown-item" href="seller_login.php">Seller Login</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <section id="hero">
        <h4>Trade-in-offer</h4>
        <h2>Super value deals</h2>
        <h1>On all product</h1>
        <p>Save more with coupons & up to <span>70% off!</span></p>
        <button>Shop Now</button>

    </section>

    <div class="container mt-5 mb-4">
        <h3 class="text-center mb-4">Shop by Category</h3>
        <div class="row text-center">
            <div class="col-6 col-md-3 mb-3">
                <a href="index.php?category=Men's Clothing" class="text-dark" style="text-decoration:none;">
                    <img src="https://images.unsplash.com/photo-1617137968427-85924c800a22?w=200&h=200&fit=crop" class="rounded-circle img-fluid shadow-sm" alt="Men's Clothing">
                    <h5 class="mt-3">Men's Clothing</h5>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <a href="index.php?category=Women's Clothing" class="text-dark" style="text-decoration:none;">
                    <img src="https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?w=200&h=200&fit=crop" class="rounded-circle img-fluid shadow-sm" alt="Women's Clothing">
                    <h5 class="mt-3">Women's Clothing</h5>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <a href="index.php?category=Laptops" class="text-dark" style="text-decoration:none;">
                    <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=200&h=200&fit=crop" class="rounded-circle img-fluid shadow-sm" alt="Laptops">
                    <h5 class="mt-3">Laptops</h5>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <a href="index.php?category=Mobiles" class="text-dark" style="text-decoration:none;">
                    <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=200&h=200&fit=crop" class="rounded-circle img-fluid shadow-sm" alt="Mobiles">
                    <h5 class="mt-3">Mobiles</h5>
                </a>
            </div>
        </div>
    </div>

    <?php
include("config.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM product WHERE 1=1";
$params = [];
$types = "";

if ($search != '') {
    $sql .= " AND product_name LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}
if ($min_price != '') {
    $sql .= " AND product_price >= ?";
    $params[] = $min_price;
    $types .= "i";
}
if ($max_price != '') {
    $sql .= " AND product_price <= ?";
    $params[] = $max_price;
    $types .= "i";
}
if ($category != '') {
    $sql .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

    <div class="container" id="products">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                <form class="form-inline justify-content-center" method="GET" action="index.php">
                    <input type="text" name="search" class="form-control mr-2" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                    <input type="number" name="min_price" class="form-control mr-2" placeholder="Min Price" value="<?php echo htmlspecialchars($min_price); ?>">
                    <input type="number" name="max_price" class="form-control mr-2" placeholder="Max Price" value="<?php echo htmlspecialchars($max_price); ?>">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="index.php" class="btn btn-secondary ml-2">Clear</a>
                </form>
            </div>
        </div>
        <div class="row">
            <?php
        while($row=mysqli_fetch_array($result))
        {
        ?>
            <div class="col-lg-4 mt-3 mb-3">
                <div class="card-deck">
                    <div class="card border-info p-2">
                        <img src="<?php echo $row['product_image'];?>" class="card-img-top" height="320">
                        <h5 class="card-title">Product :-<?php echo $row['product_name'];?> </h5>
                        <h3 class="card-title">Product :-<?php echo number_format($row['product_price']);?> </h3>
                        <a class="btn btn-warning btn-block btn-lg" href="details.php?id=<?php echo $row['id'];?>"> View Details</a>
                        <a class="btn btn-danger btn-block btn-lg" href="order.php?id=<?php echo $row['id'];?>"> Buy Now</a>
                        <a class="btn btn-info btn-block btn-lg" href="add_to_cart.php?id=<?php echo $row['id'];?>"> Add to Cart</a>
                    </div>

                </div>

            </div>
            <?php 
            }
            ?>

        </div>

    </div>






    <?php if (isset($_SESSION['recently_viewed']) && count($_SESSION['recently_viewed']) > 0): ?>
    <div class="container mt-5 mb-5">
        <h3 class="mb-4">Recently Viewed</h3>
        <div class="row">
            <?php
            $recent_ids = implode(',', array_map('intval', $_SESSION['recently_viewed']));
            $recent_sql = "SELECT * FROM product WHERE id IN ($recent_ids) ORDER BY FIELD(id, $recent_ids)";
            $recent_result = mysqli_query($conn, $recent_sql);
            while($recent_row = mysqli_fetch_assoc($recent_result)):
            ?>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-secondary p-2 h-100">
                    <img src="<?php echo $recent_row['product_image'];?>" class="card-img-top" height="200" style="object-fit: contain;">
                    <div class="card-body text-center p-2">
                        <h6 class="card-title"><?php echo $recent_row['product_name'];?></h6>
                        <a class="btn btn-sm btn-warning" href="details.php?id=<?php echo $recent_row['id'];?>">View Details</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>

</body>

</html>