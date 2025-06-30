<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
  echo "Registered successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="user.css" />
</head>
<body>

  <div class="auth-container">
    <h2 class="auth-title">Create Account</h2>
    <form method="POST" action="">
      <input type="text" name="name" class="auth-input" placeholder="Full Name" required />
      <input type="email" name="email" class="auth-input" placeholder="Email" required />
      <input type="password" name="password" class="auth-input" placeholder="Password" required />
      <button type="submit" class="auth-btn">Register</button>
    </form>
    <a href="user_login.php" class="auth-link">Already have an account? Login</a>
  </div>

</body>
</html>

