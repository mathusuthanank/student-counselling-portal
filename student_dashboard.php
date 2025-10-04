<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT username, email, rollno ,programme_name FROM users WHERE id = '$student_id' AND user_type = 'student'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

// Fetch the mentor of the student
$mentor_sql = "SELECT u.username, u.email FROM staff_student_allocation ssa
               JOIN users u ON ssa.staff_id = u.id
               WHERE ssa.student_id = '$student_id' AND ssa.role = 'mentor-mentee'";
$mentor_result = mysqli_query($conn, $mentor_sql);
$mentor = mysqli_fetch_assoc($mentor_result);

// Fetch the tutor of the student
$tutor_sql = "SELECT u.username, u.email FROM staff_student_allocation ssa
              JOIN users u ON ssa.staff_id = u.id
              WHERE ssa.student_id = '$student_id' AND ssa.role = 'tutor-student'";
$tutor_result = mysqli_query($conn, $tutor_sql);
$tutor = mysqli_fetch_assoc($tutor_result);

// Fetch replies for the student
$replies_sql = "SELECT message FROM replies WHERE user_id = '$student_id' ORDER BY created_at DESC";
$replies_result = mysqli_query($conn, $replies_sql);
$replies = mysqli_fetch_all($replies_result, MYSQLI_ASSOC);

// Fetch leave requests for the student
$leave_requests_sql = "SELECT leave_type, from_date, to_date, description, status FROM leave_applications WHERE student_id = '$student_id' ORDER BY created_at DESC";
$leave_requests_result = mysqli_query($conn, $leave_requests_sql);
$leave_requests = mysqli_fetch_all($leave_requests_result, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="stdDash.css"> 
    <style>
        .details-container {
            display: flex;
            justify-content: space-between;
        }
        .details-container div {
            width: 45%;
        }
        .details-container p {
            margin: 5px 0;
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
        <h2>Student Dashboard</h2>
        <div class="profile-container">
            <h3>Profile</h3>
            <p><strong>Username:</strong> <?php echo $student['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
            <p><strong>Rollno:</strong> <?php echo isset($student['rollno']) ? $student['rollno'] : ''; ?></p>
            <p><strong>Department:</strong> <?php echo isset($student['programme_name']) ? $student['programme_name'] : ''; ?></p>
        </div>
        <div class="details-container">
            <div class="mentor-container">
                <h3>Mentor Details</h3>
                <?php if ($mentor): ?>
                    <p><strong>Mentor Name:</strong> <?php echo $mentor['username']; ?></p>
                    <p><strong>Mentor Email:</strong> <?php echo $mentor['email']; ?></p>
                <?php else: ?>
                    <p>No mentor assigned.</p>
                <?php endif; ?>
            </div>
            <div class="tutor-container">
                <h3>Tutor Details</h3>
                <?php if ($tutor): ?>
                    <p><strong>Tutor Name:</strong> <?php echo $tutor['username']; ?></p>
                    <p><strong>Tutor Email:</strong> <?php echo $tutor['email']; ?></p>
                <?php else: ?>
                    <p>No tutor assigned.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="content-container">
            <ul>
                <li><a href="collect_details.php">Submit Details</a></li>
                <li><a href="viewStudentDetails.php?rollno=<?php echo $student['rollno']; ?>">View Details</a></li>
                <li><a href="one_on_one_counseling.php">One-on-one Counseling</a></li>
                <li><a href="statusonCounseling.php">Status on Counseling</a></li>
                <li><a href="e_leave_form.php">Apply for leave and OD</a></li>
                <li><a href="statusonleave.php">Status on leave and OD</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
