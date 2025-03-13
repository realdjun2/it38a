<?php
$host = "localhost";
$dbname = "login_system";
$username = "root"; // Change this if necessary
$password = ""; // Change this if necessary

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
