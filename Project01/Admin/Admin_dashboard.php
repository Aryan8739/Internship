<?php
session_start();
 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    echo "Access denied. Admin only.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Dark Tech</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="Admin_dashboard_style.css" />
</head>
<body>

  <div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
      <h2 class="admin-logo">DARK TECH</h2>
      <nav>
        <a href="Admin_dashboard.php" class="active">Dashboard</a> <br> <br>
        <a href="caraousel.php">Manage Caraousel</a> <br> <br>
        <a href="admin_product.php">Manage Products</a> <br> <br>
        <a href="admin_add_funds.php">Manage Funds</a> <br> <br>
        <a href="admin_ledger.php">View Ledger</a> <br> <br>
        <a href="#"> 
          <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['is_admin']) && !empty($_SESSION['admin_name'])) {
    echo "Admin: " . htmlspecialchars($_SESSION['admin_name']);
} else {
    echo "Access denied or invalid ";
}
?></a> <br> <br>
        <a href="admin_logout.php ">Logout</a>
        
 


      </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
      <header class="admin-header">
        <h1>Admin Dashboard </h1>
      </header>
      <section class="admin-content">
        <p>Welcome, Admin! Choose an action from the sidebar.</p>
        <!-- Future: include dynamic content here -->
      </section>
    </main>
  </div>

</body>
</html>
