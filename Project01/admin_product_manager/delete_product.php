<?php
include 'conn.php';

$id = $_GET['id'] ?? 0;

if ($id) {
    $sql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: Admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
