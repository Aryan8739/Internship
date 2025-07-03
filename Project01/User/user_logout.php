<?php

session_start();
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
header("Location: ../index2.php");
exit;


?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Logout</title>
  <link rel="stylesheet" href="../styles.css" />
</head>
<body>
 <!-- Header -->
  <header class="header">
    <div class="top-bar">Free shipping on orders over ₹999 • 30-day returns • Warranty included   </div>
    <div class="header-main">
      <div class="container">
        <div class="header-content">
          <a href="index2.php" class="logo">
            <div class="logo-icon">DT</div>
            <span class="logo-text">Dark Tech</span>
          </a>
          <nav class="nav-desktop">
            <a href="../index2.php" class="nav-link ">Home</a>
            <a href="../products2.php" class="nav-link ">Products</a>
            <a href="../Project01/User/login_land.php" class="nav-link">Login</a>
            <a href="../login.php" class="nav-link">Admin</a>
            <a href ="#" class = 'nav-link'> <?php
              session_start();
              if (isset($_SESSION['user'])) {
                echo "Welcome, " . htmlspecialchars($_SESSION['user']['name']);
                
              } else {
                echo "Guest";
              } 
              ?></a>
              <a href="../cart.php" class="nav-link">Cart</a>
            <a href ="#" class = 'nav-link'> 
              <?php
              if (isset($_SESSION['user'])) {
                echo '<a href="../Project01/User/user_logout.php" class="nav-link">Logout</a>';
              }
              ?>
              
          </nav>
        </div>
      </div>
    </div>
  </header>
  <div class="auth-container">
    <h2 >Logged Out</h2>
    <p class="logout-message">You have been successfully logged out.</p>
    <a href="user_login.php" class="auth-btn">Login Again</a>
  </div>

</body>
</html>
