<?php
include 'db.php';
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate user input
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error_message = "Both username and password are required.";
    } else {
        // Prepare the SQL query
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $stored_username, $hashed_password);

        // Verify credentials
        if ($stmt->fetch() && password_verify($password, $hashed_password)) {
            // Correct login, store user data in session
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $stored_username;

            // Redirect user to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Incorrect username or password
            $error_message = "Invalid username or password.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!-- Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    
    <?php if (isset($error_message)): ?>
        <div style="color: red;"><?= htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required placeholder="Enter your username">
        <br><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required placeholder="Enter your password">
        <br><br>

        <button type="submit">Login</button>
    </form>

    <p><a href="forgot_password.php">Forgot Password?</a></p>
    <p>Don't have an account? <a href="register.php">Sign up</a></p>
</body>
</html>

