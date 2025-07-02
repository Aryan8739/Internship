<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login before placing an order.";
    echo "<br><a href='login.php'>Login</a>";
    exit;
}

// ✅ Ensure cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='../Project01/index2.php'>Go back to shop</a></p>";
    exit;
}

$user_id = $_SESSION['user_id'];


$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}


$stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, order_date) VALUES (?, ?, NOW())");
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();
$order_id = $stmt->insert_id;


$stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($_SESSION['cart'] as $product_id => $item) {
    $stmt_item->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
    $stmt_item->execute();
}


unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Placed</title>
    <style>
        body { font-family: Arial; padding: 20px; text-align: center; }
        .success { color: green; font-size: 22px; }
        .back-link { margin-top: 20px; display: inline-block; font-size: 16px; }
    </style>
</head>
<body>
    <p class="success">🎉 Your order has been placed successfully!</p>
    <p>Order ID: <strong>#<?= $order_id ?></strong><br>Total: ₹<?= $total ?></p>
    <a class="back-link" href="../Project01/index2.php">Continue Shopping</a>
</body>
</html>
