<?php
session_start();
include 'db.php';

// Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Resources</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>Learning Resources</h1>
            <ul><li><a href="dashboard.php">Back to Dashboard</a></li></ul>
        </div>
    </header>

    <div class="container">
        <h3>Faculty Uploads</h3>
        <p>Download course materials, slides, and books here.</p>
        
        <table>
            <tr>
                <th>Course Code</th>
                <th>Resource Title</th>
                <th>Faculty Name</th>
                <th>Download Link</th>
            </tr>

            <?php
            // Join Resources with Course and Faculty tables to get names instead of IDs
            $sql = "SELECT Course.code, Resources.description, Faculty.name, Resources.link 
                    FROM Resources 
                    JOIN Course ON Resources.c_id = Course.c_id 
                    JOIN Faculty ON Resources.t_id = Faculty.t_id";
            
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['code'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    // Display link as a clickable button
                    echo "<td><a href='" . $row['link'] . "' target='_blank'><button style='padding:5px;'>Download</button></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No resources uploaded yet.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>