<?php
session_start();
include '../includes/db.php';
$s_id = $_SESSION['user_id'];

$sql = "SELECT * FROM Student WHERE s_id='$s_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>My Profile</h1>
            <ul><li><a href="dashboard.php">Back to Dashboard</a></li></ul>
        </div>
    </header>

    <div class="container" style="background:white; padding:20px; margin-top:20px;">
        <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
        <p><strong>ID:</strong> <?php echo $user['s_id']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Department:</strong> <?php echo $user['dept']; ?></p>
        <p><strong>CGPA:</strong> <?php echo $user['cgpa']; ?></p>
    </div>
</body>
</html>