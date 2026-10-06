<?php
session_start();
include("config.php");
$msg = "";
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')");
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Admin registration successful! Please login.'); window.location.href='admin_login.php';</script>";
    } else {
        $msg = "Registration failed. Email might be already in use.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-secondary p-4 rounded shadow">
                <h2 class="text-center mb-4">Admin Registration</h2>
                <?php if($msg) echo "<p class='text-danger'>$msg</p>"; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-warning btn-block">Register as Admin</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="admin_login.php" class="text-white">Already have an admin account? Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
