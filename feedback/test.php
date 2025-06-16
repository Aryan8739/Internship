<?php
$conn = mysqli_connect('localhost', 'root', '', 'project',3307);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
} else {
    echo "Connected to the 'project' database successfully!";
}


// Array
$sql = "SELECT * FROM feedback";
$query = mysqli_query($conn, $sql);  
if (mysqli_num_rows($query) > 0) {
    while ($row =mysqli_fetch_array($query)) {
    print_r($row);
       die; 
    }
} else {
    echo "No records found.";
}
 $conn->close();
?>



<!-- Table -->
<?php
// $sql = "SELECT * FROM feedback";
// $query = mysqli_query($conn, $sql);  

// if ($query && mysqli_num_rows($query) > 0) {
//     echo "<section class='feedback-display'>";
//     echo "<h2>Previous Feedback</h2>";
//     echo "<table border='1' cellpadding='10' cellspacing='0'>";
//     echo "<tr><th>Name</th><th>Email</th><th>Rating</th><th>Feedback</th><th>Date/Time</th></tr>";

//     while ($row = mysqli_fetch_assoc($query)) {
//         echo "<tr>";
//         echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
//         echo "<td>" . htmlspecialchars($row['email']) . "</td>";
//         echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
//         echo "<td>" . htmlspecialchars($row['feedback']) . "</td>";
//         echo "<td>" . htmlspecialchars($row['datetime']) . "</td>";
//         echo "</tr>";
//     }

//     echo "</table>";
//     echo "</section>";
// } else {
//     echo "<p>No records found.</p>";
// }



// Add this at the top for debugging
echo '<pre>'; print_r($_POST); echo '</pre>';

$conn->close();
?>


