<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied. Only admins can access this page.");
}

// Get all users for dropdown
$user_list = $conn->query("SELECT id, name FROM users ORDER BY name ASC");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = (int)$_POST['user_id'];
    $amount = floatval($_POST['amount']);


    // Create wallet if not exists
$check = $conn->query("SELECT * FROM wallets WHERE user_id = $user_id");
if ($check->num_rows == 0) {
    $conn->query("INSERT INTO wallets (user_id, balance) VALUES ($user_id, 0.00)");
}

    // Credit wallet
    $conn->query("UPDATE wallets SET balance = balance + $amount WHERE user_id = $user_id");

    // Log transaction
    $stmt = $conn->prepare("INSERT INTO wallet_transactions (user_id, type, amount, description) VALUES (?, 'credit', ?, 'Admin top-up')");
    $stmt->bind_param("id", $user_id, $amount);
    $stmt->execute();

    echo "<p style='color: green;'>₹$amount added successfully to User ID $user_id</p>";
}
?>

<h2>Admin - Add Funds to User Wallet</h2>

<form method="POST">
  <label>Select User:</label>
  <select name="user_id" required>
    <option value="">-- Select User --</option>
    <?php while ($user = $user_list->fetch_assoc()): ?>
      <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?> (ID: <?= $user['id'] ?>)</option>
    <?php endwhile; ?>
  </select><br><br>

  <label>Amount (₹):</label>
  <input type="number" name="amount" min="1" required><br><br>

  <button type="submit">Add Funds</button>
</form>
