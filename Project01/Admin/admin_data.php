<?php
include_once '../conn.php';

//  Taking input from form
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

        header('Location: Admin_dashboard.php');
        exit();
    
    }
    else {
        echo "<script>
    alert('Invalid Username or Password');
    window.location.href = '/Internship/Project01/login.php';
</script>";

        
    }?>

