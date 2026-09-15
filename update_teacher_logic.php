<?php
include 'db.php';

if(isset($_POST['update_teacher'])){
    $id = $_POST['t_id'];
    $name = mysqli_real_escape_string($conn, $_POST['t_name']);
    $sub  = mysqli_real_escape_string($conn, $_POST['t_subject']);
    $edu  = mysqli_real_escape_string($conn, $_POST['t_education']);
    $class = mysqli_real_escape_string($conn, $_POST['t_class']);

    // UPDATE Query
    $sql = "UPDATE teachers SET 
            t_name = '$name', 
            t_subject = '$sub', 
            t_education = '$edu', 
            t_class = '$class' 
            WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Update fail ho gaya: " . mysqli_error($conn);
    }
}
?>