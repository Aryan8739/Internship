<?php
session_start();
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
unset($_SESSION['is_admin']);
header("Location: login.php");
exit;
