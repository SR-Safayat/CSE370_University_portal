<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'teacher') { header("Location: index.php"); exit(); }

$t_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['submit_grade'])) {
    $s_id = $_POST['s_id'];
    $c_id = $_POST['c_id'];
    $grade = $_POST['grade'];
    $semester = "Spring2025"; // Hardcoded for this semester

    // Check if grade already exists
    $check = "SELECT * FROM Result WHERE s_id='$s_id' AND c_id='$c_id'";
    $res = $conn->query($check);

    if ($res->num_rows > 0) {
        // Update existing grade
        $sql = "UPDATE Result SET grade='$grade' WHERE s_id='$s_id' AND c_id='$c_id'";
        $message = "Grade updated!";
    } else {
        // Insert new grade
        $sql = "INSERT INTO Result (s_id, c_id, grade, semester) VALUES ('$s_id', '$c_id', '$grade', '$semester')";
        $message = "Grade submitted!";
    }
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Grades</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Grading Portal</h1>
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
                    $sql = "SELECT * FROM Course WHERE t_id = '$t_id'";
                    $res = $conn->query($sql);
                    while($row = $res->fetch_assoc()) {
                        echo "<option value='".$row['c_id']."'>".$row['code']."</option>";
                    }
                    ?>
                </select>

                <label>Enter Student ID</label>
                <input type="text" name="s_id" placeholder="e.g., 101" required>

                <label>Grade</label>
                <select name="grade">
                    <option value="A">A</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="F">F</option>
                </select>

                <button type="submit" name="submit_grade">Submit Result</button>
            </form>
        </div>
    </div>
</body>
</html>