<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$page = $_GET['page'] ?? 'dashboard';

// --- SAVE FORM HANDLERS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_student'])) {
        $email = mysqli_real_escape_string($conn, $_POST['student_email']);
        mysqli_query($conn, "INSERT INTO users (email, password, type) VALUES ('$email', 'student123', 'student')");
        header("Location: admin_dashboard.php?page=students");
        exit();
    }
    if (isset($_POST['save_class'])) {
        $cname = mysqli_real_escape_string($conn, $_POST['class_name']);
        $section = mysqli_real_escape_string($conn, $_POST['section_name']);
        mysqli_query($conn, "INSERT INTO classes (class_name, section) VALUES ('$cname', '$section')");
        header("Location: admin_dashboard.php?page=classes");
        exit();
    }
    if (isset($_POST['save_teacher'])) {
        $tname = mysqli_real_escape_string($conn, $_POST['t_name']);
        $subj  = mysqli_real_escape_string($conn, $_POST['t_subj']);
        $edu   = mysqli_real_escape_string($conn, $_POST['t_edu']);
        $cls   = mysqli_real_escape_string($conn, $_POST['t_cls']);
        
        // Exact Column Names: t_name, t_subject, t_education, t_class
        mysqli_query($conn, "INSERT INTO teachers (t_name, t_subject, t_education, t_class) VALUES ('$tname', '$subj', '$edu', '$cls')");
        header("Location: admin_dashboard.php?page=teachers");
        exit();
    }
    if (isset($_POST['save_section'])) {
        $sec_name = mysqli_real_escape_string($conn, $_POST['sec_name']);
        
        // Exact Column Name: section_name
        mysqli_query($conn, "INSERT INTO sections (section_name) VALUES ('$sec_name')");
        header("Location: admin_dashboard.php?page=sections");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - School System</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { margin: 0; display: flex; background-color: #1a1a2e; color: #fff; min-height: 100vh; }
        .sidebar { width: 220px; background-color: #16213e; padding: 20px; display: flex; flex-direction: column; gap: 8px; border-right: 1px solid #0f3460; }
        .sidebar h2 { color: #fff; font-size: 20px; margin-bottom: 20px; text-align: center; }
        .sidebar a { color: #a6b0cf; text-decoration: none; padding: 12px 15px; border-radius: 8px; font-weight: 500; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: #0f3460; color: #4e73df; }
        .sidebar a.logout { margin-top: auto; color: #e94560; }

        .main-content { flex: 1; padding: 30px; }
        .header-banner { background: #0f3460; padding: 15px 20px; border-radius: 10px; font-size: 22px; font-weight: bold; margin-bottom: 25px; color: #fff; }
        
        .form-card { background: #16213e; padding: 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #0f3460; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; align-items: end; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { color: #a6b0cf; font-size: 13px; font-weight: bold; }
        
        input[type="text"], input[type="email"], select {
            width: 100%; padding: 10px 12px; border-radius: 6px; border: 1px solid #0f3460; background: #0f3460; color: #fff; font-size: 14px; outline: none;
        }

        .btn-primary { background: #e94560; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; height: 38px; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; }
        .stat-card { background: #16213e; padding: 20px; border-radius: 10px; border: 1px solid #0f3460; text-align: center; }
        .stat-card h4 { margin: 0; color: #a6b0cf; font-size: 14px; }
        .stat-card p { margin: 10px 0 0; font-size: 24px; font-weight: bold; color: #4e73df; }

        table { width: 100%; border-collapse: collapse; background: #16213e; border-radius: 10px; overflow: hidden; margin-top: 15px; border: 1px solid #0f3460; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #0f3460; color: #cbd5e1; font-size: 14px; }
        th { background: #0f3460; color: #fff; }
        
        .btn-edit { background: #f39c12; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; margin-right: 5px; display: inline-block; }
        .btn-delete { background: #e74c3c; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; display: inline-block; }

        .profile-card { background: #16213e; border-radius: 12px; padding: 25px; width: 350px; text-align: center; margin: 20px auto; border: 1px solid #0f3460; }
        .profile-card h3 { color: #4e73df; margin-bottom: 10px; }
        .profile-card p { color: #a6b0cf; margin: 8px 0; font-size: 14px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="?page=dashboard" class="<?php echo $page == 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
        <a href="?page=users" class="<?php echo $page == 'users' ? 'active' : ''; ?>">Users</a>
        <a href="?page=students" class="<?php echo $page == 'students' ? 'active' : ''; ?>">Students</a>
        <a href="?page=profile" class="<?php echo $page == 'profile' ? 'active' : ''; ?>">Profile</a>
        <a href="?page=classes" class="<?php echo $page == 'classes' ? 'active' : ''; ?>">Classes</a>
        <a href="?page=teachers" class="<?php echo $page == 'teachers' ? 'active' : ''; ?>">Teachers</a>
        <a href="?page=sections" class="<?php echo $page == 'sections' ? 'active' : ''; ?>">Sections</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="main-content">

        <!-- DASHBOARD -->
        <?php if ($page == 'dashboard'): ?>
            <div class="header-banner">Admin Dashboard</div>
            <div class="stats-grid">
                <div class="stat-card">
                    <h4>All Students</h4>
                    <p><?php $q = mysqli_query($conn, "SELECT id FROM users WHERE type='student'"); echo $q ? mysqli_num_rows($q) : 0; ?></p>
                </div>
                <div class="stat-card">
                    <h4>All Teachers</h4>
                    <p><?php $q = mysqli_query($conn, "SELECT id FROM teachers"); echo $q ? mysqli_num_rows($q) : 0; ?></p>
                </div>
                <div class="stat-card">
                    <h4>All Classes</h4>
                    <p><?php $q = mysqli_query($conn, "SELECT id FROM classes"); echo $q ? mysqli_num_rows($q) : 0; ?></p>
                </div>
                <div class="stat-card">
                    <h4>All Sections</h4>
                    <p><?php $q = mysqli_query($conn, "SELECT id FROM sections"); echo $q ? mysqli_num_rows($q) : 0; ?></p>
                </div>
            </div>

        <!-- USERS PAGE -->
        <?php elseif ($page == 'users'): ?>
            <div class="header-banner">All Registered Users</div>
            <table>
                <thead>
                    <tr><th>ID</th><th>Email</th><th>Password</th><th>Type</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM users");
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['password']}</td>
                            <td>{$row['type']}</td>
                            <td>
                                <a href='edit.php?id={$row['id']}&type=user' class='btn-edit'>Edit</a>
                                <a href='delete.php?id={$row['id']}&type=user' class='btn-delete'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

        <!-- STUDENTS PAGE -->
        <?php elseif ($page == 'students'): ?>
            <div class="header-banner">Students Management</div>
            <div class="form-card">
                <form method="POST" class="form-grid">
                    <div class="form-group">
                        <label>Student Email</label>
                        <input type="email" name="student_email" placeholder="Enter student email" required>
                    </div>
                    <button type="submit" name="save_student" class="btn-primary">Save Student</button>
                </form>
            </div>
            <table>
                <thead><tr><th>#</th><th>Email</th><th>Type</th><th>Action</th></tr></thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM users WHERE type='student'");
                    if ($res && mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['type']}</td>
                                <td><a href='delete.php?id={$row['id']}&type=user' class='btn-delete'>Delete</a></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>No students registered yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        <!-- PROFILE PAGE -->
        <?php elseif ($page == 'profile'): ?>
            <div class="header-banner">Student Profile</div>
            <div class="profile-card">
                <h3>Ali Khan</h3>
                <p><strong>Class:</strong> 10th</p>
                <p><strong>Email:</strong> ali@gmail.com</p>
                <p><strong>Phone:</strong> 03001234567</p>
                <p><strong>Address:</strong> Peshawar</p>
            </div>

        <!-- CLASSES PAGE -->
        <?php elseif ($page == 'classes'): ?>
            <div class="header-banner">Add Class</div>
            <div class="form-card">
                <form method="POST" class="form-grid">
                    <div class="form-group">
                        <label>Class Name</label>
                        <input type="text" name="class_name" placeholder="Enter class name" required>
                    </div>
                    <div class="form-group">
                        <label>Section</label>
                        <select name="section_name">
                            <option value="Green">Green</option>
                            <option value="Pink">Pink</option>
                            <option value="Blue">Blue</option>
                        </select>
                    </div>
                    <button type="submit" name="save_class" class="btn-primary">Save Class</button>
                </form>
            </div>
            <table>
                <thead>
                    <tr><th>#</th><th>Class Name</th><th>Section</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM classes");
                    if ($res && mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['class_name']}</td>
                                <td>{$row['section']}</td>
                                <td>
                                    <a href='edit.php?id={$row['id']}&type=class' class='btn-edit'>Edit</a>
                                    <a href='delete.php?id={$row['id']}&type=class' class='btn-delete'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>No classes added yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        <!-- TEACHERS PAGE -->
        <?php elseif ($page == 'teachers'): ?>
            <div class="header-banner">Teacher Registration</div>
            <div class="form-card">
                <form method="POST" class="form-grid">
                    <div class="form-group">
                        <label>Teacher Name</label>
                        <input type="text" name="t_name" placeholder="Enter teacher name" required>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="t_subj" placeholder="Enter subject" required>
                    </div>
                    <div class="form-group">
                        <label>Education</label>
                        <input type="text" name="t_edu" placeholder="Enter education" required>
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <select name="t_cls">
                            <option value="9th">9th</option>
                            <option value="10th">10th</option>
                            <option value="11th">11th</option>
                            <option value="12th">12th</option>
                        </select>
                    </div>
                    <button type="submit" name="save_teacher" class="btn-primary">Save Teacher</button>
                </form>
            </div>
            <table>
                <thead>
                    <tr><th>#</th><th>Name</th><th>Subject</th><th>Education</th><th>Class</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM teachers");
                    if ($res && mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['t_name']}</td>
                                <td>{$row['t_subject']}</td>
                                <td>{$row['t_education']}</td>
                                <td>{$row['t_class']}</td>
                                <td>
                                    <a href='edit.php?id={$row['id']}&type=teacher' class='btn-edit'>Edit</a>
                                    <a href='delete.php?id={$row['id']}&type=teacher' class='btn-delete'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center;'>No teachers added yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        <!-- SECTIONS PAGE -->
        <?php elseif ($page == 'sections'): ?>
            <div class="header-banner">Sections Management</div>
            <div class="form-card">
                <form method="POST" class="form-grid">
                    <div class="form-group">
                        <label>Section Name</label>
                        <input type="text" name="sec_name" placeholder="Enter section name (e.g. Green)" required>
                    </div>
                    <button type="submit" name="save_section" class="btn-primary">Save Section</button>
                </form>
            </div>
            <table>
                <thead><tr><th>ID</th><th>Section Name</th><th>Action</th></tr></thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM sections");
                    if ($res && mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['section_name']}</td>
                                <td>
                                    <a href='edit.php?id={$row['id']}&type=section' class='btn-edit'>Edit</a>
                                    <a href='delete.php?id={$row['id']}&type=section' class='btn-delete'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' style='text-align:center;'>No sections added yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

</body>
</html>