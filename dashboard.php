<?php 
session_start(); 

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
    
    <?php if ($is_admin): ?>
        <h3>Admin Dashboard</h3>
        <p>You have access to admin features.</p>
        <!-- Admin-specific links go here -->
        <a href="admin_settings.php">Admin Settings</a> |
        <a href="user_management.php">Manage Users</a> |
        <a href="admin_reports.php">Admin Reports</a>
    <?php else: ?>
        <h3>User Dashboard</h3>
        <p>You have access to user features only.</p>
        <!-- User-specific links go here -->
        <a href="user_profile.php">View Profile</a> |
        <a href="user_orders.php">My Orders</a>
    <?php endif; ?>
    
    <a href="logout.php">Logout</a>
</body>
</html>

