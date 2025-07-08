<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB Connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'proj'; // ✅ Replace with your actual database name if different

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("❌ DB Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
    $price = mysqli_real_escape_string($conn, $_POST['price'] ?? '');
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');

    // Handle optional numeric fields
    $original_price = isset($_POST['original_price']) && $_POST['original_price'] !== ''
        ? mysqli_real_escape_string($conn, $_POST['original_price'])
        : 'NULL';

    $rating = isset($_POST['rating']) && $_POST['rating'] !== ''
        ? mysqli_real_escape_string($conn, $_POST['rating'])
        : 'NULL';

    $reviews_count = isset($_POST['reviews_count']) && $_POST['reviews_count'] !== ''
        ? mysqli_real_escape_string($conn, $_POST['reviews_count'])
        : 'NULL';

    // Image upload
    $upload_dir = 'assets/';
    $image_url = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                die("❌ Failed to create upload folder. Check folder permissions.");
            }
        }

        $image_name = basename($_FILES['image']['name']);
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_url = $upload_dir . $image_name;

        if (!move_uploaded_file($image_tmp, $image_url)) {
            die("❌ Failed to upload image.");
        }
    }
    $check = $conn->prepare("SELECT id FROM products WHERE name = ? OR image_url = ?");
$check->bind_param("ss", $name, $image_url);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script>alert('⚠️ A product with the same name or image already exists!'); window.history.back();</script>";
    exit;
}

$check->close();

    // Insert query (with NULL-safe formatting)
    $sql = "INSERT INTO products 
            (name, description, price, original_price, category, image_url, rating, reviews_count)
            VALUES 
            ('$name', '$description', '$price', $original_price, '$category', '$image_url', $rating, $reviews_count)";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('✅ Product added successfully!'); window.location.href='../Project01/Admin/admin_dashboard.php';</script>";
    } else {
        echo "❌ SQL Error: " . mysqli_error($conn);
    }
}
?>

<!-- HTML FORM -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>Price:</label><br>
        <input type="number" name="price" step="0.01" required><br><br>

        <label>Original Price (optional):</label><br>
        <input type="number" name="original_price" step="0.01"><br><br>

        <label>Category (optional):</label><br>
        <input type="text" name="category"><br><br>

        <label>Rating (optional):</label><br>
        <input type="number" name="rating" step="0.1" min="0" max="5"><br><br>

        <label>Reviews Count (optional):</label><br>
        <input type="number" name="reviews_count" min="0"><br><br>

        <label>Image:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
