<?php
session_start();

// Unset all admin-related session variables
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['is_admin']);

// Optionally clear all session variables
// session_unset();  // Uncomment if you want to clear ALL session data

// Destroy the session if needed
session_destroy(); // Uncomment if you want to destroy session entirely

// Redirect to login page
header("Location: ../login.php");
exit;
?>
