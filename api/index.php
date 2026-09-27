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
        <a href="#"><img src="img/logo.png" class="logo" alt=""></a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Category</a>
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
    <?php
include("config.php");
$sql="select * from product";
$result=mysqli_query($conn,$sql);

?>

    <div class="container">
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
                        <a class="btn btn-danger btn-block btn-lg" href="order.php?id=<?php echo $row['id'];?>"> Buy Now</a>
                    </div>

                </div>

            </div>
            <?php 
            }
            ?>

        </div>

    </div>






</body>

</html>