<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        $res = $conn->query("SELECT * FROM products WHERE id = $product_id");
        if ($row = $res->fetch_assoc()) {
            $_SESSION['cart'][$product_id] = [
                'name' => $row['caption'],
                'price' => $row['price'],
                'quantity' => 1,
            ];
        }
    }
    header("Location: cart.php");
    exit;
}

echo "<h2>Your Cart</h2>";
$total = 0;

if (empty($_SESSION['cart'])) {
    echo "Cart is empty.";
} else {
    foreach ($_SESSION['cart'] as $id => $item) {
        $subtotal = $item['price'] * $item['quantity'];
        echo "{$item['name']} - ₹{$item['price']} x {$item['quantity']} = ₹$subtotal<br>";
        $total += $subtotal;
    }
    echo "<hr><strong>Total: ₹$total</strong><br><br>";
    echo '<form method="POST" action="checkout.php"><button type="submit">Proceed to Checkout</button></form>';
}
?>
