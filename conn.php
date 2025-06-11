<?php 

$host = "localhost";
$username = "root";
$pass = "";
$DB_name = "project";

$port =  "3307";

$conn = new mysqli($host , $username, $pass, $DB_name , $port);
if (!$conn) {
    die("COnnection not established");
} else{
    // echo "connected";
    // die;
}