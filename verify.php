<?php
session_start();
include 'db.php';

if (isset($_POST['login_btn'])) {
    // Inputs ko sanitize karna (SQL Injection protection)
    $email = mysqli_real_escape_string($conn, $_POST['u_email']);
    $password = mysqli_real_escape_string($conn, $_POST['u_pass']);

    // Database check query
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Session variables store karna
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_type'] = $row['type'];
        $_SESSION['user_id'] = $row['id'];

        // Dashboard par redirect karna
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Galat login info par error message ke sath wapis bhej dena
        header("Location: login.php?error=Invalid Email or Password");
        exit();
    }
} else {
    // Direct link access rokna
    header("Location: login.php");
    exit();
}
?>