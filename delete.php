<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? null;

if ($id && $type) {
    if ($type === 'user') {
        mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
        header("Location: admin_dashboard.php?page=users");
    } elseif ($type === 'class') {
        mysqli_query($conn, "DELETE FROM classes WHERE id='$id'");
        header("Location: admin_dashboard.php?page=classes");
    } elseif ($type === 'teacher') {
        mysqli_query($conn, "DELETE FROM teachers WHERE id='$id'");
        header("Location: admin_dashboard.php?page=teachers");
    } elseif ($type === 'section') {
        mysqli_query($conn, "DELETE FROM sections WHERE id='$id'");
        header("Location: admin_dashboard.php?page=sections");
    }
    exit();
} else {
    header("Location: admin_dashboard.php");
    exit();
}
?>