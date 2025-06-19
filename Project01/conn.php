<?php

$username = 'root';
$password = '';
$database = 'proj';
$host = 'localhost';

$conn = mysqli_connect($host,$username,$password,$database);
if (!$conn) {
    die("Connection Failed:" . mysqli_connect_error());
}
else {
    echo "connection Successfull";
}


?>