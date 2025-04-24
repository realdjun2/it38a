<?php
$host = "localhost";
$dbname = "login_system";
$username = "root"; // Change this if necessary
$password = ""; // Change this if necessary

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get the role of a user by their username
function getUserRole($username) {
    global $conn;

    // Prepare the SQL query to get the user's role
    $stmt = $conn->prepare("SELECT role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($role);

    if ($stmt->fetch()) {
        return $role;
    } else {
        return null; // User not found
    }

    $stmt->close();
}

// Function to check if the user is an admin
function isAdmin($username) {
    return getUserRole($username) === 'admin';
}

// Function to check if the user is a teacher
function isTeacher($username) {
    return getUserRole($username) === 'teacher';
}

// Function to check if the user is a student
function isStudent($username) {
    return getUserRole($username) === 'student';
}

?>

