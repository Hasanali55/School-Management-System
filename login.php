<?php
session_start();

// Agar user pehle se login hai, toh usay dashboard par bhej do
if (isset($_SESSION['user_email'])) {
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School System - Login</title>
    <style>
        body {
            background-color: #1a1a2e;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }
        .login-box {
            background-color: #16213e;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            width: 350px;
            text-align: center;
        }
        h2 { margin-bottom: 25px; color: #e94560; }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background-color: #0f3460;
            color: white;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            border: none;
            border-radius: 8px;
            background-color: #e94560;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #cf3a54;
        }
        .error-msg {
            background-color: #ff4d4d;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if (isset($_GET['error'])) { ?>
        <div class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php } ?>

    <form action="verify.php" method="POST">
        <input type="email" name="u_email" placeholder="Email Address" required>
        <input type="password" name="u_pass" placeholder="Password" required>
        <input type="submit" name="login_btn" value="Login Now">
    </form>
</div>

</body>
</html>