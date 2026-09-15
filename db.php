<?php
$host = "localhost";
$user = "root";     // XAMPP ka default user
$pass = "";         // XAMPP ka default password khali hota hai
$db_name = "school"; // Yahan apne database ka sahi naam likhein

// Connection banana
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Check karna ke connection hua ya nahi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>