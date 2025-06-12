<?php
if (isset($_POST['user_name'])) {
    // Connection Establishment....
    $server = "localhost";
    $username = "root";
    $password = "";


    $conn = mysqli_connect($server, $username, $password, "project", 3307);

    if (!$conn) {
        die("Connectiom Failed due to " . mysqli_connect_error());
    } else {
        // echo "Successfully Connected to DB";

    }
    // SQL Query



    $user_name = $_POST["user_name"] ?? '';   //??'' to avoid warning
    $email = $_POST["email"] ?? '';
    $rating = $_POST["rating"] ?? '';
    $feedback = $_POST["feedback"] ?? '';

    $sql = "INSERT INTO `project`.`feedback` (`user_name`,`email`,`rating`,`feedback`,`datetime`) VALUES('$user_name','$email','$rating','$feedback',current_timestamp());";
    // echo $sql;

    // Execution.....
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($conn->query($sql) == true) {
            echo "Successfully Inserted";
        } else {
            echo "ERROR: $sql  <br>  $conn->error";
        }
        $conn->close();
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Feedback </title>
    <link rel="stylesheet" href="feedback_style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <header>
        <div class="container header-content">
            <h1 class="logo">Feed back Form</h1>
            <nav class="nav-links">
                <!-- <a href="#" class="nav-btn"></a>
        <a href="#" class="nav-btn"></a>
        <a href="#" class="nav-btn"></a>
        <a href="#" class="nav-btn"></a> -->
                <!-- <a href="feedback.html" class="nav-btn"></a> -->
            </nav>
        </div>
    </header>

    <!-- Feedback Form -->
    <section class="feedback-form-section">
        <div class="form-container">
            <h2>We value your feedback</h2>
            <p>Please let us know how we can improve your experience.</p>
            <form action="#" method="post">
                <label for="name">Your Name</label>
                <input type="text" id="user_name" name="user_name" placeholder="Enter your name" required>

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="rating">Rating</label>
                <select id="rating" name="rating" required>
                    <option value="" disabled selected>Select a rating</option>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Terrible</option>
                </select>

                <label for="message">Your Feedback</label>
                <textarea id="message" name="feedback" rows="5" placeholder="Write your feedback here..." required></textarea>

                <button type="submit" class="btn">Submit Feedback</button>
            </form>
        </div>
        <div class="nav-buttons">
                <a href="update.html"><button class="btn">Update Data</button></a>
                <a href="delete.html"><button class="btn">Delete Data</button></a>
            </div>
        </div>
    </section>

    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Feedback Form . Built with ❤️ by Aryan.</p>
    </footer>

</body>

</html>
