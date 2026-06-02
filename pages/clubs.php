<?php
session_start();
include '../includes/db.php';

// Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$s_id = $_SESSION['user_id'];
$message = "";

// --- 1. HANDLE POST ACTIONS (Join or Leave) ---

// JOIN Logic
if (isset($_POST['join_club'])) {
    $club_id = $_POST['club_id'];
    $role = "Member"; 

    // Check if already a member
    $check = "SELECT * FROM Club_Participation WHERE s_id='$s_id' AND club_id='$club_id'";
    $rs = $conn->query($check);

    if ($rs->num_rows > 0) {
        $message = "You are already a member!";
    } else {
        $sql = "INSERT INTO Club_Participation (club_id, s_id, role) VALUES ('$club_id', '$s_id', '$role')";
        if ($conn->query($sql)) {
            $message = "Successfully joined the club!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

// LEAVE Logic
if (isset($_POST['leave_club'])) {
    $club_id_to_leave = $_POST['club_id_leave'];
    $sql_leave = "DELETE FROM Club_Participation WHERE s_id='$s_id' AND club_id='$club_id_to_leave'";
    if ($conn->query($sql_leave)) {
        $message = "You have left the club.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// --- 2. PRE-FETCH JOINED CLUBS ---
// We create a list of IDs the student has joined so we can check it later
$my_joined_clubs = array();
$sql_check = "SELECT club_id FROM Club_Participation WHERE s_id='$s_id'";
$res_check = $conn->query($sql_check);
while($row = $res_check->fetch_assoc()) {
    $my_joined_clubs[] = $row['club_id']; // Add ID to our list
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>University Clubs</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>Student Clubs</h1>
            <ul><li><a href="dashboard.php">Back to Dashboard</a></li></ul>
        </div>
    </header>

    <div class="container">
        
        <?php if($message != "") { echo "<p style='color:green; font-weight:bold; text-align:center; background: #e8f5e9; padding: 10px; border: 1px solid #c8e6c9;'>$message</p>"; } ?>

        <h3>My Memberships</h3>
        <table>
            <tr>
                <th>Club Name</th>
                <th>Category</th>
                <th>My Role</th>
                <th>Action</th>
            </tr>
            <?php
            $sql_my = "SELECT Clubs.club_id, Clubs.name, Clubs.category, Club_Participation.role 
                       FROM Club_Participation 
                       JOIN Clubs ON Club_Participation.club_id = Clubs.club_id 
                       WHERE Club_Participation.s_id = '$s_id'";
            $res_my = $conn->query($sql_my);

            if ($res_my->num_rows > 0) {
                while($row = $res_my->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['role'] . "</td>";
                    
                    // The REMOVE Button
                    echo "<td>
                            <form method='post' onsubmit=\"return confirm('Leave this club?');\">
                                <input type='hidden' name='club_id_leave' value='" . $row['club_id'] . "'>
                                <button type='submit' name='leave_club' style='background-color: #d32f2f; padding: 5px 10px; font-size: 12px; width: auto;'>Leave</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>You have not joined any clubs yet.</td></tr>";
            }
            ?>
        </table>

        <hr>

        <h3>All Available Clubs</h3>
        <div class="dashboard-grid">
            <?php
            $sql_all = "SELECT * FROM Clubs";
            $res_all = $conn->query($sql_all);

            while($club = $res_all->fetch_assoc()) {
                // Check if this specific club is in our 'my_joined_clubs' list
                $is_joined = in_array($club['club_id'], $my_joined_clubs);
            ?>
                <div class="card">
                    <h3><?php echo $club['name']; ?></h3>
                    <p><strong>Category:</strong> <?php echo $club['category']; ?></p>
                    
                    <?php if ($is_joined) { ?>
                        
                        <button disabled style="background-color: #777; cursor: default;">Joined ✓</button>
                    
                    <?php } else { ?>
                        
                        <form method="post">
                            <input type="hidden" name="club_id" value="<?php echo $club['club_id']; ?>">
                            <button type="submit" name="join_club" style="background: green;">Join Club</button>
                        </form>
                        
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <div style="text-align: center; margin-top: 40px; margin-bottom: 20px;">
            <p style="color: #666; font-style: italic;">Not interested in any clubs right now?</p>
            <a href="dashboard.php">
                <button style="background-color: #555; width: 200px;">Back to Dashboard</button>
            </a>
        </div>

    </div>
</body>
</html>