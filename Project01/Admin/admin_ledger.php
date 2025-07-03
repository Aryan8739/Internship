<?php
session_start();
include '../conn.php';

// Only allow admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied. Admins only.");
}

// Fetch all transactions with user names
$sql = "SELECT wt.*, u.name AS user_name
        FROM wallet_transactions wt
        JOIN users u ON wt.user_id = u.id
        ORDER BY wt.created_at DESC";

$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Wallet Ledger</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    th { background-color: #eee; }
    h2 { margin-bottom: 10px; }
  </style>
</head>
<body>

<h2>Admin - Wallet Transaction Ledger</h2>

<table>
  <tr>
    <th>User ID</th>
    <th>User Name</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Description</th>
    <th>Timestamp</th>
  </tr>

  <?php while ($row = $res->fetch_assoc()): ?>
    <tr>
      <td><?= $row['user_id'] ?></td>
      <td><?= htmlspecialchars($row['user_name']) ?></td>
      <td><?= ucfirst($row['type']) ?></td>
      <td>₹<?= number_format($row['amount'], 2) ?></td>
      <td><?= htmlspecialchars($row['description']) ?></td>
      <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
