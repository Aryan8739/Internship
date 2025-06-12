<?php
$conn = mysqli_connect('localhost', 'root', '', 'project',3307);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
} else {
    echo "Connected to the 'project' database successfully!";
}
?>
