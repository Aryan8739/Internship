<?php
session_start();




include 'conn.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle "Add to Cart"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $product_id = (int)$_POST['product_id'];

    // Check if product exists in DB
    $res = $conn->query("SELECT * FROM products WHERE id = $product_id");
    if ($row = $res->fetch_assoc()) {
        // Add or update quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => 1
            ];
        }
        $message = "Added to cart!";
    }
}
?>


<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dark Tech - Home</title>
  <link rel="stylesheet" href="styles.css">
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
            <a href="index2.php" class="nav-link  ">Home</a>
            <a href="products2.php" class="nav-link ">Products</a>
           <?php
session_start(); // only if not already started
$isLoggedIn = isset($_SESSION['user_id']);
$targetPage = $isLoggedIn ? '../Project01/wallet_dashboard.php' : '../Project01/User/login_land.php';
?>
<a href="<?= $targetPage ?>" class="nav-link"><?= $isLoggedIn ? 'My Wallet' : 'Login' ?></a>

            <a href="login.php" class="nav-link">Admin</a>
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
              if (isset($_SESSION['user_id'])) {
                echo '<a href="../Project01/User/user_logout.php" class="nav-link">Logout</a>';
              }
              ?>
              
          </nav>
        </div>
      </div>
    </div>
  </header>
  
    
<!-- Carousel Start -->
<div class="carousel">
  <?php
    $carouselQuery = "SELECT * FROM CarouselData WHERE is_active = 1";
    $carouselResult = mysqli_query($conn, $carouselQuery);

    if (mysqli_num_rows($carouselResult) > 0) {
      $index = 0;
      echo '<div class="carousel-inner">';
      while ($row = mysqli_fetch_assoc($carouselResult)) {
        $activeClass = ($index === 0) ? 'active' : '';
        echo '
          <div class="carousel-item ' . $activeClass . '">
            <img src="' . htmlspecialchars($row['image_url']) . '" alt="Slide ' . ($index + 1) . '" />
            <div class="carousel-caption">' . htmlspecialchars($row['caption']) . '</div>
          </div>';
        $index++;
      }
      echo '</div>';
    } else {
      echo '<p>No slides found.</p>';
    }
  ?>
  
    <!-- Carousel Controls -->
    <button class="carousel-btn carousel-prev" id="carouselPrev">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <polyline points="15,18 9,12 15,6"></polyline>
      </svg>
    </button>

    <button class="carousel-btn carousel-next" id="carouselNext">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <polyline points="9,6 15,12 9,18"></polyline>
      </svg>
    </button>

    <!-- Carousel Indicators -->
    <div class="carousel-indicators" id="carouselIndicators">
      <button class="indicator active" data-slide="0"></button>
      <button class="indicator" data-slide="1"></button>
      <button class="indicator" data-slide="2"></button>
    </div>
  </div>
</section>
</div>
<!-- Carousel End -->



<?php
// --- index2.php ---
include 'conn.php';
session_start();

$sql = "SELECT * FROM products";
$res = $conn->query($sql);

while ($product = $res->fetch_assoc()) {
?>
  <div class="product-card">
    <img src="<?= $product['image_url'] ?>" alt="Product Image">
    <h3><?= $product['caption'] ?></h3>
    <p>Price: ₹<?= $product['price'] ?></p>

    <form method="POST" action="" style="display:inline;">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <input type="hidden" name="action" value="add">
        <button class="btn btn-primary" type="submit">Add to Cart</button>
    </form>

    <form method="POST" action="checkout.php" style="display:inline;">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <input type="hidden" name="action" value="buy_now">
        <button class="btn btn-primary" type="submit">Buy Now</button>
    </form>
  </div>
<?php
}
?>


  <!-- <script src="script.js"></script> -->


  <script>
  const carousel = document.getElementById('homeCarousel');
  const slides = carousel.querySelectorAll('.carousel-slide');
  let index = 0;

  function showSlide(i) {
    carousel.style.transform = `translateX(-${i * 100}%)`;
  }

  function nextSlide() {
    index = (index + 1) % slides.length;
    showSlide(index);
  }

  if (slides.length > 1) {
    setInterval(nextSlide, 4000); // change every 4 sec
  }
</script>


</body>
</html>
