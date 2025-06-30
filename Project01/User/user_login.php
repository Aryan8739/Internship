<?php
include_once '../conn.php';

session_start();

if ($_SERVER["REQUEST_METHOD"]== 'POST'){
    $id =$_POST['id'];
    $name =$_POST['name'];
    $user = $_POST['email'];
    $pass = $_POST['password'];

    $res = $conn-> query("SELECT * FROM users WHERE email = '$user'");
    $user = $res->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user'] = $user; //->name;

    
        
        header("Location: ../index2.php");
        exit;
    } else {
        echo "Invalid email or password.";
    }
}

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="user.css" />
</head>
<body>

  <div class="auth-container">
    <h2 class="auth-title">Welcome Back</h2>
    <form method="POST" action="">
      <input type="text" name="email" class="auth-input" placeholder="email" required />
      <input type="password" name="password" class="auth-input" placeholder="Password" required />
      <button type="submit" class="auth-btn">Login</button>
    </form>
    <a href="user_registration.php" class="auth-link">Don't have an account? Register</a>
  </div>

</body>
</html>








    <!-- // Prepare and execute the SQL statement to prevent SQL injection
    // $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    // $stmt->bind_param("s", $user);
    // $stmt->execute();
    // $result = $stmt->get_result(); -->
