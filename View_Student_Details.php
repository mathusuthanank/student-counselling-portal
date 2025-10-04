<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['staff_id'])) {
    header('Location: login.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="stf.css">
</head>
<body>
    <header>
<h1>Student Counselling Portal</h1>
    <nav>
        <ul>
            <li><a href="staff_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    
    </header>
       
        
        
        <div class="view-student-details">
            <h3>View Student Details</h3>
            <form method="GET" action="viewStudentDetails.php">
                <label for="rollno">Enter Student Roll No:</label>
                <input type="text" id="rollno" name="rollno" required>
                <button type="submit">View Details</button>
            </form>
        </div>
        <div id="dynamic-content">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>
</body>
</html>
