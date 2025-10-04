<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_type = $_POST['leave_type'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $description = $_POST['description'];

    // Fetch the tutor assigned to the student
    $tutor_sql = "SELECT staff_id FROM staff_student_allocation WHERE student_id = '$student_id' AND role = 'tutor-student'";
    $tutor_result = mysqli_query($conn, $tutor_sql);
    $tutor = mysqli_fetch_assoc($tutor_result);

    if ($tutor) {
        $tutor_id = $tutor['staff_id'];
        $sql = "INSERT INTO leave_applications (student_id, leave_type, from_date, to_date, description, status) VALUES ('$student_id', '$leave_type', '$from_date', '$to_date', '$description', 'pending')";
        if (mysqli_query($conn, $sql)) {
            $leave_id = mysqli_insert_id($conn);
            $notification_sql = "INSERT INTO notifications (user_id, message) VALUES ('$tutor_id', 'New leave request from student. <a href=\"respond_leave_request.php?leave_id=$leave_id&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=$leave_id&action=reject\">Reject</a>')";
            mysqli_query($conn, $notification_sql);
            echo "Leave application submitted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "No tutor assigned to the student.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
    <link rel="stylesheet" href="leave.css">
</head>
<body>
<header>
    
    <h1>Student Counselling Portal</h1>
    <nav>
        <ul>
            <li><a href="student_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    </header>
    <div class="container">
        <h2>Apply for Leave and OD</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="leave_type">Select leave type</label>
                <select id="leave_type" name="leave_type" required>
                    <option value="">Select leave type...</option>
                    <option value="casual">Casual Leave</option>
                    <option value="medical">Medical Leave</option>
                    <option value="on_duty">On Duty</option>
                </select>
            </div>
            <div class="form-group">
                <label for="from_date">From Date</label>
                <input type="date" id="from_date" name="from_date" required>
            </div>
            <div class="form-group">
                <label for="to_date">To Date</label>
                <input type="date" id="to_date" name="to_date" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit">Apply</button>
            </div>
        </form>
    </div>
</body>
</html>
