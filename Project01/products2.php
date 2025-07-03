<?php
session_start();
include 'conn.php';

// --- Cart Logic ---
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];

    // Add to cart only
    $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($product = $result->fetch_assoc()) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$productId] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Products - Dark Tech</title>
  <link rel="stylesheet" href="styles.css" />
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
          <a href="index2.php" class="nav-link">Home</a>
          <a href="products2.php" class="nav-link">Products</a>
          <?php
            $isLoggedIn = isset($_SESSION['user_id']);
            $targetPage = $isLoggedIn ? '../Project01/wallet_dashboard.php' : '../Project01/User/login_land.php';
          ?>
          <a href="<?= $targetPage ?>" class="nav-link"><?= $isLoggedIn ? 'My Wallet' : 'Login' ?></a>
          <a href="login.php" class="nav-link">Admin</a>
          <a href="#" class="nav-link">
            <?php
              if (isset($_SESSION['user_id'])) {
                echo "Welcome, " . htmlspecialchars($_SESSION['user_name']);
              } elseif (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                echo "Admin: " . htmlspecialchars($_SESSION['admin_name']);
              } else {
                echo "Guest";
              }
            ?>
          </a>
          <a href="cart.php" class="nav-link">Cart</a>
          <?php
            if (isset($_SESSION['user_id'])) {
              echo '<a href="../Project01/User/user_logout.php" class="nav-link">Logout</a>';
            } elseif (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
              echo '<a href="admin_logout.php" class="nav-link">Logout</a>';
            }
          ?>
        </nav>
      </div>
    </div>
  </div>
</header>

<!-- Main Products Section -->
<main class="products-page">
  <div class="container">
    <h1 class="page-title">All Products</h1>
    <div class="products-grid">
      <?php
        $query = "SELECT * FROM products ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '
              <div class="product-card">
                <img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image"/>
                <h2 class="product-name">' . htmlspecialchars($row['name']) . '</h2>
                <p class="product-desc">' . htmlspecialchars($row['description']) . '</p>
                <p class="product-price">₹' . htmlspecialchars($row['price']) . '</p>

                <form method="POST" action="">
                  <input type="hidden" name="product_id" value="' . $row['id'] . '"/>
                  <button type="submit" name="action" value="add_to_cart" class="btn">Add to Cart</button>
                </form>
                <a href="checkout.php?buy_now=1&product_id=' . $row['id'] . '" class="btn btn-primary">Buy Now</a>
              </div>
            ';
          }
        } else {
          echo "<p>No products found.</p>";
        }
      ?>
    </div>
  </div>
</main>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="footer-content">
      <div class="footer-brand">
        <a href="index2.php" class="footer-logo">
          <div class="logo-icon">DT</div>
          <span class="logo-text">Dark Tech</span>
        </a>
        <p class="footer-description">Your trusted hub for the best in tech.</p>
      </div>
    </div>
  </div>
</footer>

</body>
</html>
