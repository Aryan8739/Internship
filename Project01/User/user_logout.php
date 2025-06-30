<?php

session_start();

session_unset(); // Unset all session variables
session_destroy(); // Destroy the session   


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Logout</title>
  <link rel="stylesheet" href="user.css" />
</head>
<body>

  <div class="auth-container">
    <h2 class="auth-title">Logged Out</h2>
    <p class="logout-message">You have been successfully logged out.</p>
    <a href="user_login.php" class="auth-btn">Login Again</a>
  </div>

</body>
</html>
