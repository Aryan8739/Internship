<?php
// You can add session checks here later
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
        <a href="#" class="active">Dashboard</a> <br> <br>
        <a href="#">Manage NavBar</a> <br> <br>
        <a href="#">Manage Products</a> <br> <br>
        <a href="#">Logout</a>
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
