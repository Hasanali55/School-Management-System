<?php
include 'db.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM teachers WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        header("location: admin_dashboard.php");
        exit();
    }else{
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
