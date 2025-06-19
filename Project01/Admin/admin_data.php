<?php
include_once 'conn.php';

//  Tkaking input from form
if ($_SERVER['REQUEST_METHOD']== 'POST'){
    $user_name = $_POST["username"] ?? '';
    $pass =$_POST["password"] ?? '';

}

// fetching data from db
    $query = 'SELECT * FROM  proj.AdminData '.
        "WHERE username = '$user_name' AND password = '$pass'";
    $result = mysqli_query($conn, $query);

    // checking for username and password
    if (mysqli_num_rows($result)){

        header('Location: Admin_dashboard.html');
        exit();
    
    }
    else {
        echo "<script>
    alert('Invalid Username or Password');
    window.location.href = 'login.php';
</script>";

        
    }?>

