<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $url = $_POST['image_url'];
    $caption = $_POST['caption']; 
    $isActive = $_POST['is_active'] ? 1 : 0; // Convert to integer for SQL


    $insert = "INSERT INTO CarouselData (id, image_url ,caption,is_active)
               VALUES ('$id', '$url', '$caption', '$isActive')";

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
  <label>Id: <input type="number" name="id"></label><br>
  <label>Img Url: <input type="text" name="url"></label><br>
  <label>Caption : <input type="text" name="caption"></label><br>
  <label>IsActive : <input type="number" name="isactive"></label><br>
 
  <button type="submit">Add Product</button>
</form>
