<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <header>
        <div class="container">
            <h1>University Portal</h1>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="../includes/logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>

        <div class="dashboard-grid">
            <div class="card">
                <h3>My Profile</h3>
                <p>View and edit your personal info.</p>
                <a href="profile.php"><button>Go to Profile</button></a>
            </div>

            <div class="card">
                <h3>Smart Course Adviser</h3>
                <p>Check prerequisites and enroll.</p>
                <a href="advising.php"><button>Start Advising</button></a>
            </div>

            <div class="card">
                <h3>My Results</h3>
                <p>View your transcript and grades.</p>
                <a href="result.php"><button>View Results</button></a>
            </div>
            
             <div class="card">
                <h3>Feedback & Complaints</h3>
                <p>Rate courses and report issues.</p>
                <a href="feedback.php"><button>Give Feedback</button></a>
            </div>

             <div class="card">
                <h3>Clubs</h3>
                <p>Join clubs and view activities.</p>
                <a href="clubs.php"><button>View Clubs</button></a>
            </div>

            <div class="card">
                <h3>Resources</h3>
                <p>Download slides & notes.</p>
                <a href="resources.php"><button>View Resources</button></a>
            </div>

            
        </div>
    </div>

    <style>
        .dashboard-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            width: 300px; /* Fixed width for better layout */
            box-shadow: 0 0 5px #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .card h3 { margin-top: 0; }
    </style>

</body>
</html>


