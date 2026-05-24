<?php
session_start();
include 'db.php';

$error = "";

if (isset($_POST['login_btn'])) {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Get the selected role (student or teacher)

    if ($role == 'student') {
        // --- STUDENT LOGIN LOGIC ---
        $sql = "SELECT * FROM Student WHERE s_id='$user_id' AND password='$password'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['s_id'];
            $_SESSION['user_name'] = $row['first_name'];
            $_SESSION['role'] = 'student';
            header("Location: dashboard.php"); // Go to Student Dashboard
            exit();
        } else {
            $error = "Invalid Student ID or Password!";
        }

    } else if ($role == 'teacher') {
        // --- TEACHER LOGIN LOGIC ---
        $sql = "SELECT * FROM Faculty WHERE t_id='$user_id' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['t_id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['role'] = 'teacher';
            header("Location: teacher_dashboard.php"); // Go to Teacher Dashboard
            exit();
        } else {
            $error = "Invalid Faculty ID or Password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>University Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-form">
        
        <div style="text-align: center; margin-bottom: 20px;">
            <span style="font-size: 50px;">🎓</span> </div>

        <h2>University Portal</h2>
        
        <?php if($error!="") { echo "<p style='background:#ffebee; color:#c62828; padding:10px; border-radius:3px; font-size:14px; text-align:center; border:1px solid #ef9a9a;'>$error</p>"; } ?>
        
        <form method="post" action="">
            <label>I am a:</label>
            <select name="role">
                <option value="student">Student</option>
                <option value="teacher">Faculty Member</option>
            </select>

            <label>User ID</label>
            <input type="text" name="user_id" placeholder="Enter your ID" required>
            
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            
            <button type="submit" name="login_btn">Login</button>
        </form>
    </div>

</body>
</html>