<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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
    <div class="container mt-4 mb-5">
        <h2 class="text-center p-2 text-primary mb-4">Checkout</h2>
        <form action="pay.php" method="post" accept-charset="utf-8">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($pname);?>">
            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($pprice);?>">
            <div class="row">
                <!-- Left Column: User Details & Address -->
                <div class="col-md-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">1. Delivery Address</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="10-digit Phone Number" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Street Address</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="House No, Building, Street, Area" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>State</label>
                                    <select name="state" class="form-control" required>
                                        <option value="">Select State</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Pincode</label>
                                    <input type="number" name="pincode" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Landmark (Optional)</label>
                                    <input type="text" name="landmark" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">2. Payment Options</h5>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="pay_online" name="payment_method" class="custom-control-input" value="online" checked>
                                <label class="custom-control-label" for="pay_online"><b>Credit / Debit / ATM Card / UPI</b> (via Instamojo)</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="pay_cod" name="payment_method" class="custom-control-input" value="cod">
                                <label class="custom-control-label" for="pay_cod"><b>Cash on Delivery</b></label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="<?php echo $pimage;?>" alt="<?php echo htmlspecialchars($pname);?>" class="img-fluid" style="max-height: 150px;">
                            </div>
                            <h6 class="text-truncate" title="<?php echo htmlspecialchars($pname);?>"><?php echo $pname;?></h6>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Price</span>
                                <span>₹<?php echo number_format($pprice);?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Delivery Charges</span>
                                <span class="text-success">₹<?php echo number_format($del_charge);?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between font-weight-bold mb-4">
                                <span>Total Payable</span>
                                <span>₹<?php echo number_format($total_price);?></span>
                            </div>
                            <button type="submit" name="submit" class="btn btn-warning btn-block btn-lg font-weight-bold text-dark">
                                PLACE ORDER
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>