<?php
include 'conn.php';

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $original_price = $_POST['original_price'];
    $category = $_POST['category'];
    $rating = $_POST['rating'];
    $image_url = $_POST['image_url'];

    $update = "UPDATE products SET 
        name='$name', 
        price='$price', 
        original_price='$original_price', 
        category='$category', 
        rating='$rating', 
        image_url='$image_url' 
        WHERE id=$id";

    if ($conn->query($update)) {
        header("Location: Admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post">
  <h2>Edit Product</h2>
  <label>Name: <input type="text" name="name" value="<?= $product['name'] ?>"></label><br>
  <label>Price: <input type="number" name="price" value="<?= $product['price'] ?>"></label><br>
  <label>Original Price: <input type="number" name="original_price" value="<?= $product['original_price'] ?>"></label><br>
  <label>Category: <input type="text" name="category" value="<?= $product['category'] ?>"></label><br>
  <label>Rating: <input type="number" step="0.1" name="rating" value="<?= $product['rating'] ?>"></label><br>
  <label>Image URL: <input type="text" name="image_url" value="<?= $product['image_url'] ?>"></label><br>
  <button type="submit">Save Changes</button>
</form>
