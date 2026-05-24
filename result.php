<?php
session_start();
include 'db.php';

// Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$s_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Academic Results</h1>
            <ul><li><a href="dashboard.php">Back to Dashboard</a></li></ul>
        </div>
    </header>

    <div class="container">
        <table>
            <tr>
                <th>Semester</th>
                <th>Course Name</th>
                <th>Grade</th>
            </tr>
            <?php
            // Join Result table with Course table to get Course Titles
            $sql = "SELECT Result.semester, Course.title, Result.grade 
                    FROM Result 
                    JOIN Course ON Result.c_id = Course.c_id 
                    WHERE Result.s_id = '$s_id'";
            
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['semester'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['grade'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No results found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>