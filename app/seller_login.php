<?php
session_start();
include("config.php");

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM sellers WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['status'] == 'approved') {
            if (password_verify($password, $row['password'])) {
                $_SESSION['seller_id'] = $row['id'];
                $_SESSION['seller_name'] = $row['name'];
                header("Location: seller_dashboard.php");
                exit();
            } else {
                $message = "Invalid password.";
            }
        } else if ($row['status'] == 'pending') {
            $message = "Your account is pending approval by the admin.";
        } else {
            $message = "Your account has been rejected.";
        }
    } else {
        $message = "Seller account not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4">Seller Login</h3>
                        <?php if($message): ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block mt-4">Login</button>
                            <a href="index.php" class="btn btn-link btn-block">Back to Home</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
