<?php
include '../conn.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Carousel - Admin</title>
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
    <h1>All Carousel</h1>
    <a href="add_carousel.php" class="btn btn-primary">+ Add Carousel</a> <br> <br>
    <a href="Admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Url</th>
          <th>Caption ($)</th>

          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM CarouselData ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0):
          while ($carousel = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= $carousel['id'] ?></td>
          <td><?= htmlspecialchars($carousel['image_url']) ?></td>
          <td><?= $carousel['caption'] ?></td>

          <td class="actions">
            <a href="edit_carousel.php?id=<?= $carousel['id'] ?>">Edit</a>
            <a href="delete_carousel.php?id=<?= $carousel['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
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

