<?php
session_start();
include '../conn.php';

// ✅ Check if logged in as admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    echo "Access denied. <a href='admin_login_form.html'>Login</a>";
    exit;
}

// ✅ Fetch all orders with user info
$sql = "SELECT o.id AS order_id, o.total_amount, o.order_date,
               u.name AS user_name, u.email
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - All Orders</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    .order-box { border: 1px solid #aaa; padding: 15px; margin: 20px 0; }
    .order-header { font-weight: bold; margin-bottom: 10px; }
  </style>
</head>
<body>
  <h2>📦 All Orders (Admin Panel)</h2>

  <?php while ($order = $result->fetch_assoc()): ?>
    <div class="order-box">
      <div class="order-header">
        Order #<?= $order['order_id'] ?> — ₹<?= $order['total_amount'] ?>  
        <br>User: <?= $order['user_name'] ?> (<?= $order['email'] ?>)  
        <br>Date: <?= $order['order_date'] ?>
      </div>

      <ul>
        <?php
          $order_id = $order['order_id'];
          $item_sql = "SELECT p.name AS product_name, oi.quantity, oi.price
                       FROM order_items oi
                       JOIN products p ON oi.product_id = p.id
                       WHERE oi.order_id = $order_id";
          $items = $conn->query($item_sql);
          while ($item = $items->fetch_assoc()):
        ?>
          <li><?= $item['product_name'] ?> — ₹<?= $item['price'] ?> × <?= $item['quantity'] ?></li>
        <?php endwhile; ?>
      </ul>
    </div>
  <?php endwhile; ?>
</body>
</html>
