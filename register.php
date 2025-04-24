<?php
include 'db.php';

// Ensure form submission is via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $role = isset($_POST["role"]) ? $_POST["role"] : 'student'; // Default role is 'student'

    // Validate username length and format (for example, minimum 5 characters)
    if (strlen($username) < 5) {
        $error_message = "Username must be at least 5 characters long.";
    }
    // Validate password strength (at least 8 characters, includes numbers and letters)
    elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } elseif (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $error_message = "Password must contain at least one letter and one number.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error_message = "Username already exists. Please choose a different username.";
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user into database with default role (student or based on form)
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $role);

            // Execute the query and check for success
            if ($stmt->execute()) {
                echo "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $error_message = "Error: " . $conn->error;
            }
            $stmt->close();
        }
    }

    // Close connection if we have an error or success
    $conn->close();
}
?>

<!-- Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<!-- Show error message if there's an issue -->
<?php if (isset($error_message)): ?>

