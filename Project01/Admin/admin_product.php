<?php
include '../conn.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Products - Admin</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 2rem;
    }
    th, td {
      padding: 12px;
      border: 1px solid #444;
    }
    th {
      background-color: #222;
      color: #fff;
    }
    td {
      color: darkorchid;
    }
    .actions a {
      margin-right: 10px;
      color: var(--neon-pink);
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>All Products</h1>
    <a href="add_product.php" class="btn btn-primary">+ Add Product</a> <br> <br>
    <a href="Admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price ($)</th>
          <th>Category</th>
          <th>Rating</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM products ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0):
          while ($product = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= $product['id'] ?></td>
          <td><?= htmlspecialchars($product['name']) ?></td>
          <td><?= $product['price'] ?></td>
          <td><?= $product['category'] ?></td>
          <td><?= $product['rating'] ?></td>
          <td class="actions">
            <a href="edit_product.php?id=<?= $product['id'] ?>">Edit</a>
            <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="6">No products found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

