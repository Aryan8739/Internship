<?php
include '../conn.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


$id = $_GET['id'] ?? 0;

if ($id) {
    $sql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: admin_product.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
