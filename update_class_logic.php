<?php
include 'db.php';
if(isset($_POST['update_class'])){
    $id = $_POST['c_id'];
    $name = $_POST['class_name'];
    $sec = $_POST['class_section'];
    
    $sql = "UPDATE classes SET class_name='$name', section ='$sec' WHERE id =$id";
    
    if(mysqli_query($conn, $sql)){
        header("location:admin_dashboard.php");
    }
}
?>