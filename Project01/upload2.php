<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$target_dir = "assets/";
$filename = basename($_FILES["fileToUpload"]["name"]);
$filename = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $filename);
$target_file = $target_dir . $filename;

$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
$error_code = $_FILES["fileToUpload"]["error"];



if (!file_exists($tmp_name)) {
    echo "❌ Temp file does not exist!<br>";
    exit;
}

$content = file_get_contents($tmp_name);
if ($content === false) {
    echo "❌ Could not read the temp file.<br>";
} else {
    if (file_put_contents($target_file, $content)) {
        echo "✅ File successfully saved at $target_file<br>";
    } else {
        echo "❌ Could not write to $target_file<br>";
    }
}
?>
