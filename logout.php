<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Ensure that session cookies are deleted by setting them with a past expiration date
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to login page
header("Location: login.php");
exit();
?>

