<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "project";
$port = 3307;

$conn = new mysqli($server, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['sno'])) {
    $sno = intval($_POST['sno']);

    $sql = "DELETE FROM feedback WHERE sno = $sno";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Feedback deleted successfully. <a href='index.php'>Go back</a>";
    } else {
        echo "❌ Error: " . $conn->error;
    }
} else {
    echo "⚠️ Invalid request.";
}

$conn->close();
?>
