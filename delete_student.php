<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = $id AND type = 'student'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>