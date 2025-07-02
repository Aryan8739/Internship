<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome</title>
  <link rel="stylesheet" href="../styles.css" />
  
</head>
<body>
  
  <header class="header">
    <div class="top-bar">Free shipping on orders over ₹999 • 30-day returns • Warranty included</div>
    <div class="header-main">
      <div class="container">
        <div class="header-content">
          <a href="index2.php" class="logo">
            <div class="logo-icon">DT</div>
            <span class="logo-text">Dark Tech</span>
          </a>
          <nav class="nav-desktop">
            <a href="../index2.php" class="nav-link  ">Home</a>
            <a href="../products2.php" class="nav-link ">Products</a>
            <a href="../User/login_land.php" class="nav-link">Login</a>
            <a href="../login.php" class="nav-link">Admin</a>
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
              <a href="../cart.php" class="nav-link">Cart</a>
            <a href ="#" class = 'nav-link'> 
              <?php
              if (isset($_SESSION['user_id'])) {
                echo '<a href="../Project01/User/user_logout.php" class="nav-link">Logout</a>';
              }
              ?>
              
          </nav>
        </div>
      </div>
    </div>
  </header>

  <div class="welcome-box">
    <h1  class="welcome-title">Welcome, User</h1>

    <p class="prompt">New User?</p>
    <button onclick="location.href='user_registration.php'" class="btn btn-primary">Register</button>

    <p class="prompt">Already have an account?</p>
    <button onclick="location.href='user_fixed_login.php'" class="btn btn-primary" >Login</button>
  </div>

</body>
</html>
