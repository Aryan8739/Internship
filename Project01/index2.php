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
            <a href="index2.php" class="nav-link active ">Home</a>
            <a href="products2.php" class="nav-link ">Products</a>
            <a href="../Project01/User/login_land.html" class="nav-link">Login</a>
            <a href="login.php" class="nav-link">Admin</a>
            <a href ="#" class = 'nav-link'> <?php
              session_start();
              if (isset($_SESSION['user'])) {
                echo "Welcome, " . htmlspecialchars($_SESSION['user']['name']);
                
              } else {
                echo "Guest";
              } 
              ?></a>
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



<!-- Featured Products -->
<section class="products">
  <div class="container">
    <h2>Featured Products</h2>
    <div class="product-grid">
      <?php
      $sql = "SELECT * FROM products  LIMIT 4";
      $result = $conn->query($sql);

      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="product-card">
                  <img src="' . $row["image_url"] . '" alt="' . $row["name"] . '">
                  <h3>' . $row["name"] . '</h3>
                  <p>$' . $row["price"] . '</p>
                  <a href="product.php?id=' . $row["id"] . '" class="btn">View</a>
                </div>';
        }
      } else {
        echo '<p>No featured products available.</p>';
      }
      ?>
    </div>
  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2024 Dark Tech. All rights reserved.</p>
    </div>
  </footer>

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
