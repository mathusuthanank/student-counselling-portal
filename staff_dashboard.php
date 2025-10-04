<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['staff_id'])) {
    header('Location: login.php');
    exit();
}

$staff_id = $_SESSION['staff_id'];
$sql = "SELECT username, email,programme_name FROM users WHERE id = '$staff_id' AND user_type = 'staff'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$staff = mysqli_fetch_assoc($result);

// Fetch counseling requests
$counseling_sessions_sql = "SELECT cs.id, u.username as mentee_username, cs.session_date, cs.session_time, cs.notes, cs.status 
                            FROM counseling_sessions cs
                            JOIN users u ON cs.mentee_id = u.id
                            WHERE cs.mentor_id = '$staff_id'";
$counseling_sessions_result = mysqli_query($conn, $counseling_sessions_sql);
$counseling_sessions = mysqli_fetch_all($counseling_sessions_result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="stf.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateSessionStatus(sessionId, action) {
            $.post('respond_session.php', { session_id: sessionId, action: action }, function(response) {
                if (response.trim() === 'success') {
                    if (action === 'accept') {
                        document.querySelector(`#session-${sessionId} .action-buttons`).innerHTML = '<span>Counseling scheduled</span>';
                        document.querySelector(`#session-${sessionId} .status`).textContent = 'scheduled';
                    } else if (action === 'reject') {
                        document.querySelector(`#session-${sessionId} .action-buttons`).innerHTML = '<span>Counseling not scheduled</span>';
                        document.querySelector(`#session-${sessionId} .status`).textContent = 'not scheduled';
                    }
                } else {
                    alert('Failed to update session status.');
                }
            });
        }
    </script>
    <style>
        .no-list-style {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .no-link-effect {
            text-decoration: none;
            color: inherit;
        }

        .no-link-effect:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>
<header>
        <h1>Student Counselling Portal</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="dashboard-container">
        <h2>Staff Dashboard</h2>
        <div class="profile-container" style="text-align: left;">
            <h3>Profile</h3>
            <p><strong>Username:</strong> <?php echo $staff['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $staff['email']; ?></p>
            <p><strong>Department:</strong> <?php echo $staff['programme_name']; ?></p>
        </div>
        <div class="content-container">
            <ul class="no-list-style">
                <li><a href="students_tutorship.php" class="no-link-effect">Students tutorship</a></li>
                <li><a href="mentees_mentorship.php" class="no-link-effect">Mentees mentorship</a></li>
                <li><a href="View_Student_Details.php" class="no-link-effect">View Student Details</a></li>
            </ul>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
