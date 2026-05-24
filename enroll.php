<?php
session_start();
include 'db.php';

if (isset($_GET['cid']) && isset($_SESSION['user_id'])) {
    $s_id = $_SESSION['user_id'];
    $c_id = $_GET['cid'];
    $semester = "Summer2025"; // You can change this or make it dynamic later

    // Check if already enrolled
    $check = "SELECT * FROM Enrollment WHERE s_id='$s_id' AND c_id='$c_id'";
    $rs = $conn->query($check);

    if ($rs->num_rows > 0) {
        echo "<script>alert('You are already enrolled!'); window.location='advising.php';</script>";
    } else {
        // Insert into Database
        $sql = "INSERT INTO Enrollment (s_id, c_id, semester) VALUES ('$s_id', '$c_id', '$semester')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Successfully Enrolled!'); window.location='dashboard.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    header("Location: dashboard.php");
}
?>