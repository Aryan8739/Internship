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
    $stmt = $conn->prepare("SELECT 1 FROM wallets WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $stmt_insert = $conn->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, 0.00)");
        $stmt_insert->bind_param("i", $user_id);
        $stmt_insert->execute();
    }

    // Credit wallet
    $stmt_update = $conn->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?");
    $stmt_update->bind_param("di", $amount, $user_id);
    $stmt_update->execute();

    // Log transaction
    $stmt_log = $conn->prepare("INSERT INTO wallet_transactions (user_id, type, amount, description) VALUES (?, 'credit', ?, 'Admin top-up')");
    $stmt_log->bind_param("id", $user_id, $amount);
    $stmt_log->execute();

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

  <p><strong>Wallet Balance:</strong> ₹<span id="wallet-balance">--</span></p>

  <label>Amount (₹):</label>
  <input type="number" name="amount" min="1" required><br><br>

  <button type="submit">Add Funds</button>
</form>

<script>
document.querySelector('select[name="user_id"]').addEventListener('change', function () {
    const userId = this.value;
    const display = document.getElementById("wallet-balance");

    if (!userId) {
        display.textContent = "--";
        return;
    }

    fetch('get_wallet_balance.php?user_id=' + userId)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                display.textContent = parseFloat(data.balance).toFixed(2);
            } else {
                display.textContent = "N/A";
            }
        });
});
</script>
