<?php
session_start();
include '../includes/db.php';

// Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$s_id = $_SESSION['user_id'];
$message = "";

// --- LOGIC 1: Handle Course Feedback Submission ---
if (isset($_POST['submit_feedback'])) {
    $course_id = $_POST['course_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO Feedback (s_id, c_id, rating, comment) VALUES ('$s_id', '$course_id', '$rating', '$comment')";
    if ($conn->query($sql)) {
        $message = "Feedback submitted successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// --- LOGIC 2: Handle General Complaint Submission ---
if (isset($_POST['submit_complaint'])) {
    $desc = $_POST['description'];

    $sql = "INSERT INTO Complaints (s_id, description, status) VALUES ('$s_id', '$desc', 'Pending')";
    if ($conn->query($sql)) {
        $message = "Complaint lodged successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch courses for the dropdown menu
$course_list = $conn->query("SELECT * FROM Course");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback & Complaints</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Student Feedback Portal</h1>
            <ul><li><a href="dashboard.php">Back to Dashboard</a></li></ul>
        </div>
    </header>

    <div class="container">
        
        <?php if($message != "") { echo "<p style='color:green; font-weight:bold;'>$message</p>"; } ?>

        <div class="login-form" style="width: 60%; margin: 20px auto;">
            <h2>Rate a Course</h2>
            <form method="post">
                <label>Select Course:</label>
                <select name="course_id" style="width:100%; padding:10px; margin:10px 0;">
                    <?php while($c = $course_list->fetch_assoc()) { ?>
                        <option value="<?php echo $c['c_id']; ?>">
                            <?php echo $c['code'] . " - " . $c['title']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Rating (1-5):</label>
                <select name="rating" style="width:100%; padding:10px; margin:10px 0;">
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Very Bad</option>
                </select>

                <label>Comments:</label>
                <textarea name="comment" rows="3" style="width:100%; margin:10px 0;" required></textarea>

                <button type="submit" name="submit_feedback">Submit Feedback</button>
            </form>
        </div>

        <hr>

        <div class="login-form" style="width: 60%; margin: 20px auto; border-top: 5px solid red;">
            <h2>Lodge a Complaint</h2>
            <p>Issues with facilities, admin, or payments?</p>
            <form method="post">
                <label>Describe your issue:</label>
                <textarea name="description" rows="4" style="width:100%; margin:10px 0;" required></textarea>
                <button type="submit" name="submit_complaint" style="background:darkred;">Submit Complaint</button>
            </form>
        </div>

    </div>
</body>
</html>