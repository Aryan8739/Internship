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

<form method="POST">
  <input name="name" required placeholder="Name"><br>
  <input name="email" required type="email" placeholder="Email"><br>
  <input name="password" required type="password" placeholder="Password"><br>
  <button type="submit">Register</button>
</form>
