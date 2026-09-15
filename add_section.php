<?php
session_start();
include("db.php"); // Database se connection
if (!isset($_SESSION['user_email'])) { header("Location: login.php"); exit(); }

if (isset($_POST['save_section'])) {
    $sec_name = $_POST['secname'];
    // MySQL: Data insert karne ki query
    $query = "INSERT INTO sections (section_name) VALUES ('$sec_name')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Section Added Successfully!'); window.location='admin_dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Section</title>
    <style>
        body { background: #1a1a2e; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-box { background: #16213e; padding: 30px; border-radius: 10px; width: 300px; box-shadow: 0 4px 10px rgba(0,0,0,0.5); }
        input { width: 100%; padding: 10px; margin: 15px 0; border-radius: 5px; border: none; box-sizing: border-box; }
        button { background: #e94560; color: white; width: 100%; padding: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="form-box">
        <h3>Add New Section</h3>
        <form method="POST">
            <input type="text" name="secname" placeholder="Enter Section Name (e.g. A)" required>
            <button type="submit" name="save_section">Save Section</button>
            <br><br>
            <a href="admin_dashboard.php" style="color: #aaa; text-decoration: none; font-size: 14px;">← Back</a>
        </form>
    </div>
</body>
</html>