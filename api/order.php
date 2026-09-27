<?php
include("config.php");
if(isset($_GET['id']))
{
$id=$_GET['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM product WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);
$pname=$row['product_name'];
$pprice=$row['product_price'];

$pimage=$row['product_image'];
$del_charge=50;
$total_price=$pprice+$del_charge;


}
else{
    echo "No Product Found";
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete your order</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="#">Logo</a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Categories</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-5">
                <h2 class="text-center p-2 text-primary">
Fill the details to complete your order
                </h2>
<h3>Prduct Details :- </h3>
<table class="table table-bordered">
    <tr>
        <th>Product Name :- </th>
        <td><?php echo $pname;?></td>
        <td rowspan="4" class="text-center"><img src="<?php echo $pimage;?>" alt="" width="200px"></td>
    </tr>
    <tr>
        <th>Product Price :- </th>
        <td><?php echo number_format( $pprice);?></td>
    </tr>
    <tr>
        <th>Delivery Charge</th>
        <td><?php echo number_format($del_charge);?></td>
    </tr>
    <tr>
        <th>Total Price :- </th>
        <td><?php echo number_format($total_price);?></td>
    </tr>

</table>
<h4>Enter yours details </h4>
<form action="pay.php" method="post" accept-charset="utf-8">
<input type="hidden" name="product_name" value="<?php echo $pname?>">
<input type="hidden" name="product_price" value="<?php echo $pprice?>">
<div class="form-group">
    <input type="text" name="name" class="form-control" placeholder="Enter your name" required>

</div>
<div class="form-group">
    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>

</div>
<div class="form-group">
    <input type="number" name="phone" class="form-control" placeholder="Enter your phone" required>

</div>
<div class="form-group">
    <input type="submit" name="submit" class="btn btn-danger btn-lg" value="Click to Pay <?php echo number_format($total_price);?>" require>

</div>
</form>

            </div>

        </div>

    </div>
</body>

</html>