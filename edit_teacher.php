
<?php
include 'db.php';

// 1. Check karein ke ID mili hai ya nahi
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM teachers WHERE id = $id");
    $data = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="admin_dashboard.css"> </head>
<body style="background: #1a1a2e; color: white; padding: 50px;">

    <div class="form-card" style="max-width: 500px; margin: auto; background: #16213e; padding: 20px; border-radius: 10px;">
        <h2>Update Teacher Record</h2>
        <form action="update_teacher_logic.php" method="POST">
            
            <input type="hidden" name="t_id" value="<?php echo $data['id']; ?>">

            <label>Teacher Name:</label><br>
            <input type="text" name="t_name" value="<?php echo $data['t_name']; ?>" required style="width: 90%; padding: 10px; margin: 10px 0;"><br>

            <label>Subject:</label><br>
            <input type="text" name="t_subject" value="<?php echo $data['t_subject']; ?>" required style="width: 90%; padding: 10px; margin: 10px 0;"><br>

            <label>Education:</label><br>
            <input type="text" name="t_education" value="<?php echo $data['t_education']; ?>" required style="width: 90%; padding: 10px; margin: 10px 0;"><br>

            <label>Class:</label><br>
            <input type="text" name="t_class" value="<?php echo $data['t_class']; ?>" required style="width: 90%; padding: 10px; margin: 10px 0;"><br>

            <button type="submit" name="update_teacher" class="btn" style="background: #00d4ff; cursor: pointer;">Update Details</button>
            <a href="admin_dashboard.php" style="color: white; margin-left: 10px;">Cancel</a>
        </form>
    </div>

</body>
</html>