<?php
session_start();
// Security: Check if user is logged in AND is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>Faculty Portal</h1>
            <ul>
                <li><a href="teacher_dashboard.php">HOME</a></li>
                <li><a href="../includes/logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </header>

    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>

        <div class="dashboard-grid">
            
            <div class="card">
                <h3>My Profile</h3>
                <p>View your faculty details.</p>
                <a href="teacher_profile.php"><button>View Profile</button></a>
            </div>

            <div class="card">
                <h3>Upload Resources</h3>
                <p>Share slides with students.</p>
                <a href="upload_resource.php"><button>Upload Files</button></a>
            </div>

            <div class="card">
                <h3>Grade Students</h3>
                <p>Give marks for courses.</p>
                <a href="submit_grade.php"><button>Submit Grades</button></a>
            </div>

        </div>
    </div>
</body>
</html>