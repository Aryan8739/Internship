<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conn.php';

$id = $_GET['id'] ?? 0;
$product = null;

if ($id) {
    $sql = "SELECT * FROM CarouselData WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $url = $_POST['image_url'];
    $caption = $_POST['caption']; 
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    $update = "UPDATE CarouselData SET 
        image_url = '$url', 
        caption = '$caption',     
        is_active = '$isActive'
        WHERE id = $id";

    if ($conn->query($update)) {
        header("Location: Admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post">
  <h2>Edit Carousel</h2>
  <label>Id: <input type="number" name="id" value="<?= $product['id'] ?? '' ?>" readonly></label><br>
  <label>Img Url: <input type="text" name="image_url" value="<?= $product['image_url'] ?? '' ?>"></label><br>
  <label>Caption : <input type="text" name="caption" value="<?= $product['caption'] ?? '' ?>"></label><br>
  <label>IsActive : 
    <input type="checkbox" name="is_active" value="1" <?= ($product['is_active'] ?? 0) ? 'checked' : '' ?>>
  </label><br>
  <button type="submit">Update</button>
</form>
