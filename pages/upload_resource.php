<?php
session_start();
include '../includes/db.php';

// Only Teachers allowed
if ($_SESSION['role'] != 'teacher') { header("Location: index.php"); exit(); }

$t_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['upload'])) {
    $c_id = $_POST['c_id'];
    $desc = $_POST['description'];
    $link = $_POST['link'];

    $sql = "INSERT INTO Resources (t_id, c_id, link, description) VALUES ('$t_id', '$c_id', '$link', '$desc')";
    if ($conn->query($sql)) {
        $message = "Resource uploaded successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Resources</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Upload Course Materials</h1>
            <ul><li><a href="teacher_dashboard.php">Back to Dashboard</a></li></ul>
        </div>
    </header>

    <div class="container">
        <div class="login-form" style="margin-top: 20px;">
            <?php if($message != "") { echo "<p style='color:green;'>$message</p>"; } ?>
            
            <form method="post">
                <label>Select Course</label>
                <select name="c_id">
                    <?php
                    // Only show courses taught by THIS teacher
                    $sql = "SELECT * FROM Course WHERE t_id = '$t_id'";
                    $res = $conn->query($sql);
                    while($row = $res->fetch_assoc()) {
                        echo "<option value='".$row['c_id']."'>".$row['code']." - ".$row['title']."</option>";
                    }
                    ?>
                </select>

                <label>Description (e.g., Lecture 5 Slides)</label>
                <input type="text" name="description" required>

                <label>Link (Google Drive / PDF URL)</label>
                <input type="text" name="link" required>

                <button type="submit" name="upload">Share Resource</button>
            </form>
        </div>
    </div>
</body>
</html>