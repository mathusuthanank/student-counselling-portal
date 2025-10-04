<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['staff_id'])) {
    header('Location: login.php');
    exit();
}

$staff_id = $_SESSION['staff_id'];
$sql = "SELECT username, email FROM users WHERE id = '$staff_id' AND user_type = 'staff'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$staff = mysqli_fetch_assoc($result);

// Fetch the students under the tutorship of the logged-in staff
$sql = "SELECT u.username, u.email, u.rollno, u.id as student_id 
        FROM staff_student_allocation ssa
        JOIN users u ON ssa.student_id = u.id
        WHERE ssa.staff_id = '$staff_id' AND ssa.role = 'tutor-student'";
$students_result = mysqli_query($conn, $sql);
$students = mysqli_fetch_all($students_result, MYSQLI_ASSOC);

// Count the number of students under the tutorship
$total_students = count($students);



// Fetch leave requests for the staff to approve
$leave_requests_sql = "SELECT la.id, u.username, la.leave_type, la.from_date, la.to_date, la.description, la.status 
                       FROM leave_applications la
                       JOIN users u ON la.student_id = u.id
                       WHERE u.id IN (SELECT student_id FROM staff_student_allocation WHERE staff_id = '$staff_id' AND role = 'tutor-student') 
                       AND la.status IN ('pending', 'approved_by_tutor', 'approved_by_admin', 'rejected_by_tutor', 'rejected_by_admin')";
$leave_requests_result = mysqli_query($conn, $leave_requests_sql);
$leave_requests = mysqli_fetch_all($leave_requests_result, MYSQLI_ASSOC);



mysqli_close($conn);
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
    <div class="dashboard-container">
        <h2>Staff Dashboard</h2>
        <div class="profile-container" style="text-align: left;">
            <h3>Profile</h3>
            <p><strong>Username:</strong> <?php echo $staff['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $staff['email']; ?></p>
        </div>
        
        <div class="students-tutorship">
            <h3>Students Under Your Tutorship</h3>
            <p><strong>Total Students:</strong> <?php echo $total_students; ?></p>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Student Email</th>
                        <th>Student Roll No</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['username']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td><?php echo $student['rollno']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="leave-requests">
            <h3>Leave Requests</h3>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Leave Type</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leave_requests as $request): ?>
                        <tr>
                            <td><?php echo $request['username']; ?></td>
                            <td><?php echo $request['leave_type']; ?></td>
                            <td><?php echo $request['from_date']; ?></td>
                            <td><?php echo $request['to_date']; ?></td>
                            <td><?php echo $request['description']; ?></td>
                            <td><?php echo $request['status']; ?></td>
                            <td>
                                <?php if ($request['status'] == 'pending' || $request['status'] == 'approved_by_tutor'): ?>
                                    <form method="POST" action="respond_leave_request.php">
                                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                        <button type="submit" name="action" value="approve" onclick="this.form.submit(); this.style.display='none';">Approve</button>
                                        <button type="submit" name="action" value="reject" onclick="this.form.submit(); this.style.display='none';">Reject</button>
                                    </form>
                                <?php else: ?>
                                    Processed
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
       
        
    </div>
</body>
</html>
