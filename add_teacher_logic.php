<?php
include 'db.php';

if (isset($_POST['save_teacher'])) {
    // Form se aane wale data ko sanitize karna
    $t_name = mysqli_real_escape_string($conn, $_POST['t_name']);
    $t_subject = mysqli_real_escape_string($conn, $_POST['t_subject']);
    $t_education = mysqli_real_escape_string($conn, $_POST['t_education']);
    $t_class = mysqli_real_escape_string($conn, $_POST['t_class']);

    // Database mein teacher insert karne ki query
    $sql = "INSERT INTO teachers (t_name, t_subject, t_education, t_class) 
            VALUES ('$t_name', '$t_subject', '$t_education', '$t_class')";

    if (mysqli_query($conn, $sql)) {
        // Record save hone ke baad admin dashboard par redirect karna
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Agar direct URL access ho toh dashboard par bhej do
    header("Location: admin_dashboard.php");
    exit();
}
?>