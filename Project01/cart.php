<?php
session_start();
include 'conn.php';

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Update quantity (+/-)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $id = (int)$_POST['product_id'];

        if ($_POST['action'] === 'increase') {
            $_SESSION['cart'][$id]['quantity'] += 1;
        }

        if ($_POST['action'] === 'decrease') {
            $_SESSION['cart'][$id]['quantity'] -= 1;
            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }

        if ($_POST['action'] === 'remove') {
            unset($_SESSION['cart'][$id]);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
<link rel="stylesheet" href="styles.css" >
<style>
  .desktop {
    font-size: x-large;
    text-align:center;
  }
</style>
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
            <a href="index2.php" class="nav-link ">Home</a>
            <a href="products2.php" class="nav-link ">Products</a>
            <a href="../Project01/User/login_land.php" class="nav-link">Login</a>
            <a href="login.php" class="nav-link">Admin</a>
            <a href ="#" class = 'nav-link'> <?php
              session_start();
              if (isset($_SESSION['user'])) {
                echo "Welcome, " . htmlspecialchars($_SESSION['user']['name']);
                
              } else {
                echo "Guest";
              } 
              ?></a>
              <a href="cart.php" class="nav-link active">Cart</a>
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

<h2>Your Cart</h2>
 <div >
    <nav class="desktop">
            <a href="User/user_order.php" class="nav-link  ">ORDER HISTORY</a>
    </nav>      
    </div> 

<?php if (empty($_SESSION['cart'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <div id="cart-items">
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $item):
    
        
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>
        <div class="cart-item" data-id="<?= $id ?>">
            <h4><?= $item['name'] ?></h4>
            <p>₹<?= $item['price'] ?> x <span class="qty"><?= $item['quantity'] ?></span> = ₹<span class="subtotal"><?= $subtotal ?></span></p>

            <form method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <input type="hidden" name="action" value="increase">
                <button class="qty-btn">+</button>
            </form>

            <form method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <input type="hidden" name="action" value="decrease">
                <button class="qty-btn">−</button>
            </form>

            <form method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <input type="hidden" name="action" value="remove">
                <button class="remove-btn">Remove</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <hr>
    <p class="total">Total: ₹<span id="total"><?= $total ?></span></p>

    <form method="POST" action="checkout.php">
        <button type="submit" class="checkout-btn">Proceed to Checkout</button>
    </form>
   
<?php endif; ?>

<!-- Optional: JavaScript for live total update -->
<script>
    const items = document.querySelectorAll('.cart-item');
    let total = 0;

    items.forEach(item => {
        const qty = parseInt(item.querySelector('.qty').textContent);
        const price = parseFloat(item.querySelector('.subtotal').textContent) / qty;
        total += price * qty;
    });

    document.getElementById('total').textContent = total;
  
</script>

</body>
</html>
