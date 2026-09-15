<?php
include 'db.php';
if (isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM classes where id = $id";
    if(mysqli_query($conn, $sql)){
        header("location: admin_dashboard.php");
        exit();
    }
}
?>