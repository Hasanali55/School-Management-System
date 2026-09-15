<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? 'user';

if (!$id) {
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch record based on type
if ($type === 'user') {
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
    $data = mysqli_fetch_assoc($res);
} elseif ($type === 'class') {
    $res = mysqli_query($conn, "SELECT * FROM classes WHERE id='$id'");
    $data = mysqli_fetch_assoc($res);
}

// Update handler
if (isset($_POST['update_btn'])) {
    if ($type === 'user') {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);
        $utype = mysqli_real_escape_string($conn, $_POST['utype']);
        mysqli_query($conn, "UPDATE users SET email='$email', password='$pass', type='$utype' WHERE id='$id'");
        header("Location: admin_dashboard.php?page=users");
    } elseif ($type === 'class') {
        $cname = mysqli_real_escape_string($conn, $_POST['cname']);
        $sec = mysqli_real_escape_string($conn, $_POST['sec']);
        mysqli_query($conn, "UPDATE classes SET class_name='$cname', section='$sec' WHERE id='$id'");
        header("Location: admin_dashboard.php?page=classes");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <style>
        body { background: #1a1a2e; color: #fff; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: #16213e; padding: 25px; border-radius: 10px; width: 320px; border: 1px solid #0f3460; }
        input, select { width: 100%; padding: 10px; margin: 8px 0 15px; background: #0f3460; border: 1px solid #4e73df; color: #fff; border-radius: 5px; box-sizing: border-box; }
        button { background: #e94560; color: white; border: none; padding: 10px; width: 100%; border-radius: 5px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h3>Edit Details</h3>
        <form method="POST">
            <?php if ($type === 'user'): ?>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" required>
                <label>Password</label>
                <input type="text" name="password" value="<?php echo htmlspecialchars($data['password'] ?? ''); ?>" required>
                <label>User Type</label>
                <select name="utype">
                    <option value="admin" <?php echo (($data['type'] ?? '') == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="student" <?php echo (($data['type'] ?? '') == 'student') ? 'selected' : ''; ?>>Student</option>
                </select>
            <?php elseif ($type === 'class'): ?>
                <label>Class Name</label>
                <input type="text" name="cname" value="<?php echo htmlspecialchars($data['class_name'] ?? ''); ?>" required>
                <label>Section</label>
                <input type="text" name="sec" value="<?php echo htmlspecialchars($data['section'] ?? ''); ?>" required>
            <?php endif; ?>
            <button type="submit" name="update_btn">Update Record</button>
        </form>
    </div>
</body>
</html>