<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Handle Add Funds
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_funds'])) {
    $amount = floatval($_POST['amount']);
    $description = trim($_POST['description']);

    if ($amount > 0) {
        // Ensure wallet exists
        $check = $conn->query("SELECT * FROM wallets WHERE user_id = $user_id");
        if ($check->num_rows == 0) {
            $conn->query("INSERT INTO wallets (user_id, balance) VALUES ($user_id, 0.00)");
        }

        // Update wallet
        $conn->query("UPDATE wallets SET balance = balance + $amount WHERE user_id = $user_id");

        // Log transaction
        $stmt = $conn->prepare("INSERT INTO wallet_transactions (user_id, type, amount, description) VALUES (?, 'credit', ?, ?)");
        $stmt->bind_param("ids", $user_id, $amount, $description);
        $stmt->execute();

        // Popup JS trigger
        echo "<script>alert('₹$amount added successfully!'); window.location.href = 'wallet_dashboard.php';</script>";
        exit;
    } else {
        echo "<script>alert('Invalid amount.');</script>";
    }
}

// Fetch wallet balance
$balResult = $conn->query("SELECT balance FROM wallets WHERE user_id = $user_id");
$wallet = $balResult->fetch_assoc();
$balance = $wallet['balance'] ?? 0;

// Fetch transactions
$res = $conn->query("SELECT * FROM wallet_transactions WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Wallet Dashboard</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f0f0f0; }
    table { border-collapse: collapse; width: 100%; background: white; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    form { margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 0 8px #ccc; }
    input, textarea, button { padding: 8px; width: 100%; margin-bottom: 10px; }
    h2 { color: #333; }
  </style>
</head>
<body>

<h2>Wallet Dashboard</h2>
<p><strong>User:</strong> <?= htmlspecialchars($user_name) ?></p>
<p><strong>Current Balance:</strong> ₹<?= number_format($balance, 2) ?></p>

<form method="POST" action="wallet_dashboard.php">
  <input type="number" step="0.01" name="amount" placeholder="Amount to add (₹)" required>
  <textarea name="description" placeholder="Description" required></textarea>
  <button type="submit" name="add_funds">Add Funds</button>
</form>

<h3>Transaction History</h3>
<table>
  <tr>
    <th>Type</th>
    <th>Amount</th>
    <th>Description</th>
    <th>Time</th>
  </tr>
  <?php while ($row = $res->fetch_assoc()): ?>
    <tr>
      <td><?= ucfirst($row['type']) ?></td>
      <td>₹<?= number_format($row['amount'], 2) ?></td>
      <td><?= $row['description'] ?></td>
      <td><?= $row['created_at'] ?></td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
