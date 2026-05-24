<?php
session_start();
include 'db.php';

// Security: Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$student_id = $_SESSION['user_id'];

// 1. Get list of courses the student has ALREADY PASSED (Grade is not F)
$passed_courses = [];
$sql_passed = "SELECT c_id FROM Result WHERE s_id = '$student_id' AND grade != 'F'";
$result_passed = $conn->query($sql_passed);
while($row = $result_passed->fetch_assoc()) {
    $passed_courses[] = $row['c_id'];
}

// 2. Fetch all available courses
$sql_courses = "SELECT * FROM Course";
$all_courses = $conn->query($sql_courses);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Advising</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <header>
        <div class="container">
            <h1>Smart Advising Panel</h1>
            <ul><li><a href="dashboard.php">Back to Dashboard</a></li></ul>
        </div>
    </header>

    <div class="container">
        <h2>Available Courses for <?php echo $_SESSION['user_name']; ?></h2>
        
        <table>
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Prerequisite</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while($course = $all_courses->fetch_assoc()) { 
                $c_id = $course['c_id'];
                $c_code = $course['code'];
                
                // CHECK PREREQUISITES
                $sql_prereq = "SELECT prereq_id FROM Prerequisites WHERE course_id = '$c_id'";
                $prereq_res = $conn->query($sql_prereq);
                
                $is_locked = false;
                $prereq_name = "None";

                if ($prereq_res->num_rows > 0) {
                    $prereq_row = $prereq_res->fetch_assoc();
                    $p_id = $prereq_row['prereq_id'];
                    
                    // Get name of prerequisite for display
                    $p_name_sql = "SELECT code FROM Course WHERE c_id = '$p_id'";
                    $p_name_res = $conn->query($p_name_sql);
                    $prereq_name = $p_name_res->fetch_assoc()['code'];

                    // THE LOGIC: If prerequisite ID is NOT in passed_courses array, LOCK IT.
                    if (!in_array($p_id, $passed_courses)) {
                        $is_locked = true;
                    }
                }
                
                // DETERMINE STATUS
                if (in_array($c_id, $passed_courses)) {
                    $status = "Completed";
                    $color = "blue";
                    $action = "Taken";
                } elseif ($is_locked) {
                    $status = "Locked (Need $prereq_name)";
                    $color = "red";
                    $action = "<button disabled>Locked</button>";
                } else {
                    $status = "Open";
                    $color = "green";
                    // Link to the enrollment processor
                    $action = "<a href='enroll.php?cid=$c_id'><button>Enroll</button></a>"; 
                }
            ?>
                <tr>
                    <td><?php echo $c_code; ?></td>
                    <td><?php echo $course['title']; ?></td>
                    <td><?php echo $prereq_name; ?></td>
                    <td style="color: <?php echo $color; ?>; font-weight:bold;">
                        <?php echo $status; ?>
                    </td>
                    <td><?php echo $action; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>