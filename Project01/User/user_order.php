<?php
session_start();


include '../conn.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login to view your orders.";
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
$result = $conn->query($sql);
if (!$result) {
    die("Order Query Error: " . $conn->error);
}

?>

<h2>Your Order History</h2>

<?php while ($order = $result->fetch_assoc()): ?>
  <div style="border:1px solid #ccc; margin:10px; padding:10px;">
    <p><strong>Order ID:</strong> <?= $order['id'] ?></p>
    <p><strong>Date:</strong> <?= $order['order_date'] ?></p>
    <p><strong>Total Amount:</strong> ₹<?= $order['total_amount'] ?></p>

    <h4>Items:</h4>
    <ul>
      <?php
        $order_id = $order['id'];
        $item_query = "SELECT p.name AS product_name, oi.quantity, oi.price
                       FROM order_items oi
                       JOIN products p ON oi.product_id = p.id
                       WHERE oi.order_id = $order_id";
        $items = $conn->query($item_query);
        if (!$items) {
    echo "<li>Item Query Error: " . $conn->error . "</li>";
}

        while ($item = $items->fetch_assoc()):
      ?>
        <li><?= $item['product_name'] ?> - ₹<?= $item['price'] ?> × <?= $item['quantity'] ?></li>
      <?php endwhile; ?>
    </ul>
  </div>
<?php endwhile; ?>
