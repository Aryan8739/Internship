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

$sno = $_GET['sno'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sno = intval($_POST['sno']);
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    $sql = "UPDATE feedback SET user_name='$user_name', email='$email', rating='$rating', feedback='$feedback' WHERE sno=$sno";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Feedback updated successfully. <a href='index.php'>Go back</a>";
    } else {
        echo "❌ Error updating record: " . $conn->error;
    }
} else if ($sno !== null) {
    $sql = "SELECT * FROM feedback WHERE sno = $sno";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        ?>
        <h2>Edit Feedback</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="sno" value="<?php echo $row['sno']; ?>">
            <label>Name:</label>
            <input type="text" name="user_name" value="<?php echo htmlspecialchars($row['user_name']); ?>" required><br><br>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br><br>

            <label>Rating:</label>
            <select name="rating" required>
                <?php
                for ($i = 5; $i >= 1; $i--) {
                    $selected = ($i == $row['rating']) ? "selected" : "";
                    echo "<option value='$i' $selected>$i</option>";
                }
                ?>
            </select><br><br>

            <label>Feedback:</label><br>
            <textarea name="feedback" rows="5" cols="40"><?php echo htmlspecialchars($row['feedback']); ?></textarea><br><br>

            <button type="submit">Update</button>
        </form>
        <?php
    } else {
        echo "❌ Feedback not found.";
    }
}

$conn->close();
?>
