<?php
session_start();       // 1. Find the current session
session_destroy();     // 2. Destroy all data (log the user out)
header("Location: ../index.php");
exit();
?>