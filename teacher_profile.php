<?php
session_start();
include 'db.php';

// Security Check: Ensure user is logged in AND is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: index.php");
    exit();
}

$t_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>Faculty Profile</h1>
            <ul><li><a href="teacher_dashboard.php">Back to Dashboard</a></li></ul>
        </div>
    </header>

    <div class="container">
        <div class="dashboard-grid" style="justify-content: center;">
            
            <div class="card" style="width: 400px; text-align: left; padding: 40px;">
                <h3 style="text-align: center; color: #1a237e; border-bottom: 2px solid #ddd; padding-bottom: 15px; margin-bottom: 20px;">
                    Faculty Details
                </h3>

                <?php
                // Fetch data from the FACULTY table (not Student table)
                $sql = "SELECT * FROM Faculty WHERE t_id = '$t_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>
                    <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
                    <p><strong>Faculty ID:</strong> <?php echo $row['t_id']; ?></p>
                    <p><strong>Department:</strong> <?php echo $row['dept']; ?></p>
                    <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    
                    <p><strong>Office Room:</strong> UB20401</p> 

                <?php
                } else {
                    echo "<p>No profile data found.</p>";
                }
                ?>
                
                <div style="text-align: center; margin-top: 30px;">
                    <a href="teacher_dashboard.php">
                        <button>Back</button>
                    </a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>