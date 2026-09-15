<?php
include 'db.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM classes WHERE id = $id");
    $row = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Class</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body style="background: #1a1a2e; color: white; padding: 50px;">
    <div class="profile-card" style="max-width: 400px; margin: auto;">
        <h2>Update Class</h2>
        <form action="update_class_logic.php" method="POST">
            <input type="hidden" name="c_id" value="<?php echo $row['id']; ?>">
            
            <label>Class Name:</label><br>
            <input type="text" name="class_name" value="<?php echo $row['class_name']; ?>" required><br><br>
            
            <label>Section:</label><br>
            <select name="class_section" required>
                <option value="Green" <?php if($row['section']=='Green') echo 'selected'; ?>>Green</option>
                <option value="Pink" <?php if($row['section']=='Pink') echo 'selected'; ?>>Pink</option>
                <option value="Blue" <?php if($row['section']=='Blue') echo 'selected'; ?>>Blue</option>
            </select><br><br>
            
            <button type="submit" name="update_class" class="btn">Update Class</button>
            <a href="admin_dashboard.php" style="color: white; margin-left: 10px;">Cancel</a>
        </form>
    </div>
</body>
</html>