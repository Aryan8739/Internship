<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dark Tech - Home</title>
  <link rel="stylesheet" href="styles2.css">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="container">
      <h1>Dark Tech</h1>
      <nav>
        <!-- Search Bar -->
            <div class="search-container">
              <div class="search-box">
                
                  <circle cx="11" cy="11" r="8"></circle>
                  <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input
                  type="search"
                  placeholder="Search for products..."
                  class="search-input"
                />
              </div>
            </div>

        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="login.php">Login</a>
      </nav>
    </div>
  </header>
  
    
<section class="carousel-section">
  <div class="carousel-container">
    <div class="carousel-wrapper" id="carouselWrapper">
      <!-- Slide 1 -->
      <div class="carousel-slide active">
        <div class="carousel-content">
          <div class="carousel-bg gradient-carousel-1"></div>
          <div class="container">
            <div class="carousel-text">
              <h2 class="carousel-title">Black Friday Sale</h2>
              <p class="carousel-description">Up to 50% off on all electronics</p>
              <a href="products.html" class="btn btn-white">Shop Now</a>
            </div>
            <div class="carousel-image">
              <img
                src="https://placehold.in/600x300?text=Black+Friday+Sale"
                alt="Black Friday Sale Banner"
                style="max-width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 8px 20px rgba(0,0,0,0.3);"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-slide">
        <div class="carousel-content">
          <div class="carousel-bg gradient-carousel-2"></div>
          <div class="container">
            <div class="carousel-text">
              <h2 class="carousel-title">New Gaming Collection</h2>
              <p class="carousel-description">Latest gaming gear now available</p>
              <a href="products.html?category=gaming" class="btn btn-white">Explore Gaming</a>
            </div>
            <div class="carousel-image">
              <img
                src="https://placehold.in/600x300?text=Gaming+Gear"
                alt="Gaming Gear Banner"
                style="max-width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 8px 20px rgba(0,0,0,0.3);"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="carousel-slide">
        <div class="carousel-content">
          <div class="carousel-bg gradient-carousel-3"></div>
          <div class="container">
            <div class="carousel-text">
              <h2 class="carousel-title">Audio Excellence</h2>
              <p class="carousel-description">Premium headphones & speakers</p>
              <a href="products.html?category=audio" class="btn btn-white">Listen Now</a>
            </div>
            <div class="carousel-image">
              <img
                src="https://placehold.in/600x300?text=Audio+Products"
                alt="Audio Products Banner"
                style="max-width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 8px 20px rgba(0,0,0,0.3);"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

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

</body>
</html>
