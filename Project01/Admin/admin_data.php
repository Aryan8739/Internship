<?php
session_start();
include_once '../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST["username"] ?? '';
    $pass = $_POST["password"] ?? '';

    $query = "SELECT * FROM proj.AdminData WHERE username = '$user_name' AND password = '$pass'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result)) {
        $admin = mysqli_fetch_assoc($result);  // ✅ fetch the admin record

        // ✅ Clear any existing user session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);

        // ✅ Set admin session
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        $_SESSION['is_admin'] = true;

        header('Location: Admin_dashboard.php');
        exit();
    } else {
        echo "<script>
            alert('Invalid Username or Password');
            window.location.href = 'login.php';
        </script>";
    }
}
?>
