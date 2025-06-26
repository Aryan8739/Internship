<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conn.php';

$id = $_GET['id'] ?? 0;

if ($id) {
    $sql = "DELETE FROM CarouselData WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: Admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
