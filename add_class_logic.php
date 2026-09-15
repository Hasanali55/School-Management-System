<?php
include 'db.php';
if(isset($_POST['class_name'])){
    $name = $_POST['class_name'];
    $sec = $_POST['class_section'];
    $sql = "INSERT INTO classes (class_name, section) VALUES ('$name','$sec')";
    mysqli_query($conn, $sql);
    header("location:admin_dashboard.php");
}
?>
