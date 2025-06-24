<?php
include '../conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
    

    <style> 
          body {
            text-size-adjust: 200;
                color:rgb(255, 255, 255);
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color:rgb(34, 33, 33);
                font-family: Arial, sans-serif;
          }        
        
        h1 {
            align-content: center;
            color: #ff0080
        }
        form {
            align-self: center;
            background-color:rgb(21, 51, 74);
            padding: 100px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            margin-right: 10px;;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 13px;
            margin-bottom: 10px;
            border-radius: 50px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 15px;
            background-color: #00ffff;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center">Admin Login</h1>
    <br>
    <form action="/Internship/Project01/Admin/Admin_data.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>

    
</body>
</html>