<?php
session_start();
include 'conn.php';

echo "<h2>Checkout</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'buy_now') {
    $product_id = $_POST['product_id'];
    $res = $conn->query("SELECT * FROM products WHERE id = $product_id");
    $product = $res->fetch_assoc();
    echo "{$product['caption']} - ₹{$product['price']}<br>";
    echo "<strong>Total: ₹{$product['price']}</strong>";
} else {
    if (empty($_SESSION['cart'])) {
        echo "Your cart is empty.";
        exit;
    }

    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        echo "{$item['name']} - ₹{$item['price']} x {$item['quantity']} = ₹$subtotal<br>";
        $total += $subtotal;
    }
    echo "<hr><strong>Total: ₹$total</strong>";
}
?>
