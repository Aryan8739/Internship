<?php
include_once 'conn.php';


if ($_SERVER['REQUEST_METHOD']== 'POST'){
    $user_name = $_POST["username"] ?? '';
    $pass =$_POST["password"] ?? '';

}




?>

