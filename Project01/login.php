<?php
include '../conn.php';
session_start();


$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_name'] = $admin['username'];
$_SESSION['is_admin'] = true;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="styles.css">


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
            <a href="index2.php" class="nav-link  ">Home</a>
            <a href="products2.php" class="nav-link ">Products</a>
             <?php
session_start(); // only if not already started
$isLoggedIn = isset($_SESSION['user_id']);
$targetPage = $isLoggedIn ? '../Project01/wallet_dashboard.php' : '../Project01/User/login_land.php';
?>
<a href="<?= $targetPage ?>" class="nav-link"><?= $isLoggedIn ? 'My Wallet' : 'Login' ?></a>
            <a href="login.php" class="nav-link active">Admin</a>
            <a href ="#" class = 'nav-link'> <?php
              session_start();
             if (isset($_SESSION['user_id'])) {
                  echo "Welcome, " . htmlspecialchars($_SESSION['user_name']);
              } elseif (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                  echo "Admin: " . htmlspecialchars($_SESSION['admin_name']);
              } else {
                   echo "Guest";
}

              ?></a>
              <a href="cart.php" class="nav-link">Cart</a>
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
    <h1 style="text-align:center">Admin Login</h1>
    <br>
    <form action="/Internship/Project01/Admin/Admin_data.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>

    
</body>
</html>