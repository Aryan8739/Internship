<?php
session_start();
include '../conn.php';

// 🔐 Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please login.");
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Handle fund submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);
    $description = trim($_POST['description']);

    if ($amount <= 0) {
        echo "<script>alert('Enter a valid amount.');</script>";
    } else {
        // ✅ Ensure wallet exists
        $check = $conn->query("SELECT * FROM wallets WHERE user_id = $user_id");
        if ($check->num_rows == 0) {
            $conn->query("INSERT INTO wallets (user_id, balance) VALUES ($user_id, 0.00)");
        }

        // ✅ Add balance
        $conn->query("UPDATE wallets SET balance = balance + $amount WHERE user_id = $user_id");

        // ✅ Log transaction
        $stmt = $conn->prepare("INSERT INTO wallet_transactions (user_id, type, amount, description) VALUES (?, 'credit', ?, ?)");
        $stmt->bind_param("ids", $user_id, $amount, $description);
        $stmt->execute();

        echo "<script>alert('₹$amount added successfully.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Funds</title>
  <style>
    body { font-family: Arial; padding: 20px; background-color: #f9f9f9; }
    h2 { color: #333; }
    form { background: white; padding: 20px; max-width: 400px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
    input, textarea, button { display: block; width: 100%; margin-bottom: 15px; padding: 10px; }
    button { background: #333; color: white; border: none; cursor: pointer; }
    button:hover { background: #555; }
  </style>
</head>
<body>
  <h2>Add Funds to Your Wallet</h2>
  <p>User: <strong><?= htmlspecialchars($user_name) ?></strong></p>

  <form action="user_add_funds.php" method="POST">
    <label for="amount">Amount (₹):</label>
    <input type="number" name="amount" id="amount" step="0.01" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" placeholder="e.g. Manual top-up or offer" required></textarea>

    <button type="submit">Add Funds</button>
  </form>
</body>
</html>
