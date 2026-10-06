<?php
session_start();
include("config.php");

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email already exists
    $check_query = "SELECT * FROM sellers WHERE email='$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        $message = "Email is already registered. Please wait for approval or login.";
    } else {
        // Generate a random password
        $generated_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        $hashed_password = password_hash($generated_password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO sellers (name, email, password, status) VALUES ('$name', '$email', '$hashed_password', 'pending')";
        if(mysqli_query($conn, $sql)){
            // In a real application, we would wait for admin approval to email the password.
            // For demo purposes, we will notify the user here.
            $message = "Application submitted! Once approved by admin, you will receive an email. (For testing: Your password will be $generated_password once approved)";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Become a Seller</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4">Partner with Us - Become a Seller</h3>
                        <?php if($message): ?>
                            <div class="alert alert-info"><?php echo $message; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Company/Seller Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block mt-4">Submit Application</button>
                            <a href="index.php" class="btn btn-link btn-block">Back to Home</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
