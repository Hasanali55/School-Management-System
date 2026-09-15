<!-- <?php
session_start();
include("db.php");
if (!isset($_SESSION['user_email'])) { header("Location: login.php"); exit(); }

$id = $_GET['id']; // URL se ID pakadna

// Database se purana data nikalna
$get_data = mysqli_query($conn, "SELECT * FROM sections WHERE id = $id");
$row = mysqli_fetch_assoc($get_data);

if (isset($_POST['update_section'])) {
    $new_name = $_POST['secname'];
    // MySQL: Data update karne ki query
    $update_sql = "UPDATE sections SET section_name = '$new_name' WHERE id = $id";
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Section Updated!'); window.location='admin_dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Section</title>
    <style>
        body { background: #1a1a2e; color: white; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-box { background: #16213e; padding: 30px; border-radius: 10px; width: 300px; }
        input { width: 100%; padding: 10px; margin: 15px 0; border-radius: 5px; border: none; box-sizing: border-box; }
        button { background: #00d4ff; color: white; width: 100%; padding: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="form-box">
        <h3>Edit Section</h3>
        <form method="POST">
            <input type="text" name="secname" value="<?php echo $row['secname']; ?>" required>
            <button type="submit" name="update_section">Update Section</button>
            <br><br>
            <a href="admin_dashboard.php" style="color: #aaa; text-decoration: none; font-size: 14px;">Cancel</a>
        </form>
    </div>
</body>
</html> -->

<?php
include 'db.php';

// 1. Check karna ke URL mein ID mili ya nahi
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM sections WHERE id = $id");
    $row = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Section</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body style="background: #1a1a2e; color: white; padding: 50px;">

    <div class="profile-card" style="max-width: 400px; margin: auto; background: #16213e; padding: 20px; border-radius: 10px;">
        <h2>Edit Section</h2>
        <br>
        <form action="update_section_logic.php" method="POST">
            
            <input type="hidden" name="s_id" value="<?php echo $row['id']; ?>">
            
            <label>Section Name:</label><br>
            <input type="text" name="section_name" value="<?php echo $row['section_name']; ?>" required style="width: 90%; padding: 8px; margin: 10px 0;"><br><br>
            
            <button type="submit" name="update_section" class="btn" style="background: #00d4ff; cursor: pointer;">Update Section</button>
            <a href="admin_dashboard.php" style="color: white; margin-left: 10px; text-decoration: none;">Cancel</a>
        </form>
    </div>

</body>
</html>