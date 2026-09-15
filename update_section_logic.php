<?php
include 'db.php';

if(isset($_POST['update_section'])){
    $id = $_POST['s_id'];
    $sec_name = mysqli_real_escape_string($conn, $_POST['section_name']);

    // Database mein update ki query
    $sql = "UPDATE sections SET section_name = '$sec_name' WHERE id = $id";
    
    if(mysqli_query($conn, $sql)){
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>