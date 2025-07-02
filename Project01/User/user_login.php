<?php
include_once '../conn.php';  // adjust path if needed
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
        // ✅ Set session for logged-in user
         // Clean any old admin session if switching to user
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name']; // optional

        // ✅ Redirect to user orders or dashboard
        header("Location: ../index2.php");
        exit;
    } else {
        // ❌ Invalid login
        echo "<script>alert('Invalid email or password.'); window.location.href = 'user_login.html';</script>";
        exit;
 
     }
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['is_admin']);     
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name']; // ✅ NOT $_SESSION['user']

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="user_fixed_login.php" method="POST">
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Login</button>
</form>

</body>
</html>