<?php

session_start();

session_unset(); // Unset all session variables
session_destroy(); // Destroy the session   


?>
<!DOCTYPE html>
<html lang="en">
<h2>Loging Out in <span id="countdown">5</span> seconds...</h2>
<script>
  let count = 5;
  let interval = setInterval(() => {
    count--;
    document.getElementById("countdown").innerText = count;
    if (count === 0) {
      clearInterval(interval);
      window.location.href = "../Index2.php"; // Redirect to the homepage
    }
  }, 1000);
</script>
</html>