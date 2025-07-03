<?php
include_once '../conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Fetch user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        // ✅ Clear old admin session if present
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['is_admin']);

        // ✅ Set user session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // ✅ Create wallet if not exists
        $user_id = $user['id'];
        $walletCheck = $conn->query("SELECT * FROM wallets WHERE user_id = $user_id");
        if ($walletCheck->num_rows == 0) {
            $conn->query("INSERT INTO wallets (user_id, balance) VALUES ($user_id, 0.00)");
        }

        // ✅ Redirect to user dashboard/home
        header("Location: ../index2.php");
        exit;
    } else {
        // ❌ Invalid login
        echo "<script>alert('Invalid email or password.'); window.location.href = 'user_login.html';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Login</title>
</head>
<body>
  <form action="user_login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
  </form>
</body>
</html>
