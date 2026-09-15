<?php
include 'db.php';

if (isset($_POST['save_student'])) {
    $s_email = mysqli_real_escape_string($conn, $_POST['s_email']);
    $default_pass = "student123"; // Default student password

    // Check if user/email already exists
    $check_sql = "SELECT * FROM users WHERE email='$s_email'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) == 0) {
        $sql = "INSERT INTO users (email, password, type) VALUES ('$s_email', '$default_pass', 'student')";
        if (mysqli_query($conn, $sql)) {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Student email pehle se exist karti hai!'); window.location.href='admin_dashboard.php';</script>";
    }
}
?>