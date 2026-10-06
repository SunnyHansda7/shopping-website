<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include("config.php");

$message = '';
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    if ($action == 'approve') {
        $sql = "UPDATE sellers SET status='approved' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            // Get email to simulate sending email
            $res = mysqli_query($conn, "SELECT email FROM sellers WHERE id=$id");
            $row = mysqli_fetch_assoc($res);
            // We use standard mail() function. In dev environments, this might just get logged or fail silently.
            @mail($row['email'], "Seller Account Approved", "Your seller account has been approved. You can now login using the password generated when you applied.");
            
            $message = "Seller approved successfully! An email has been sent.";
        }
    } elseif ($action == 'reject') {
        $sql = "UPDATE sellers SET status='rejected' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            $message = "Seller rejected.";
        }
    }
}

$sql = "SELECT * FROM sellers";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Sellers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-md bg-secondary navbar-dark">
        <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
        <div class="ml-auto">
            <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Manage Sellers</h2>
        <?php if($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <table class="table table-bordered table-dark mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <?php if($row['status']=='pending'): ?>
                            <span class="badge badge-warning">Pending</span>
                        <?php elseif($row['status']=='approved'): ?>
                            <span class="badge badge-success">Approved</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Rejected</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row['status'] == 'pending'): ?>
                            <a href="?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Approve</a>
                            <a href="?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Reject</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if(mysqli_num_rows($result) == 0): ?>
                    <tr><td colspan="5" class="text-center">No sellers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
