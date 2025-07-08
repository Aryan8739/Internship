<?php
function uploadImage($file) {
    $target_dir = "assets/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $image_name = time() . "_" . basename($file["name"]);
    $target_file = $target_dir . $image_name;

    $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    // Debug: Show file info
    echo "Temp name: " . $file['tmp_name'] . "<br>";
    echo "Original name: " . $file['name'] . "<br>";
    echo "Target: $target_file<br>";
    echo "Size: " . $file['size'] . "<br>";
    echo "Type: $image_type<br>";
    echo "Error code: " . $file['error'] . "<br>";

    if (!in_array($image_type, $allowed_types)) {
        echo "Invalid file type.";
        return false;
    }

    if (!is_uploaded_file($file["tmp_name"])) {
        echo "Not a valid uploaded file.";
        return false;
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        echo "Upload success.<br>";
        return $target_file;
    } else {
        echo "move_uploaded_file failed.";
        return false;
    }
}
?>



<!-- $target_dir = "assets/";
$filename = preg_replace("/[^A-Za-z0-9.\-_]/", "_", basename($_FILES["fileToUpload"]["name"]));
$target_file = $target_dir . $filename;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".<br>";
    $uploadOk = 1;
  } else {
    echo "File is not an image.<br>";
    $uploadOk = 0;
  }
}

if (file_exists($target_file)) {
  echo "Sorry, file already exists.<br>";
  $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.<br>";
  $uploadOk = 0;
}

if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
  $uploadOk = 0;
}

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.<br>";
} else {
  


  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars($filename) . " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.<br>";
    echo "Error code: " . $_FILES["fileToUpload"]["error"] . "<br>";
    echo "Saving to: $target_file<br>";
  }
}
?> -->
