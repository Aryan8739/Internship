<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $original_price = $_POST['original_price'];
    $category = $_POST['category'];
    $rating = $_POST['rating'];
    $image_url = $_POST['image_url'];

    $insert = "INSERT INTO products (name, price, original_price, category, rating, image_url)
               VALUES ('$name', '$price', '$original_price', '$category', '$rating', '$image_url')";

    if ($conn->query($insert)) {
        header("Location: Admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post">
  <h2>Add New Product</h2>
  <label>Name: <input type="text" name="name"></label><br>
  <label>Price: <input type="number" name="price"></label><br>
  <label>Original Price: <input type="number" name="original_price"></label><br>
  <label>Category: <input type="text" name="category"></label><br>
  <label>Rating: <input type="number" step="0.1" name="rating"></label><br>
  <label>Image URL: <input type="text" name="image_url"></label><br>
  <button type="submit">Add Product</button>
</form>
