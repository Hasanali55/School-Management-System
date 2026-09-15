<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // MySQL: Data delete karne ki query
    $sql = "DELETE FROM sections WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
    }
}
?>
