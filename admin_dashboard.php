<?php
include 'db_connection.php';

// Fetch the total number of staff
$sql = "SELECT COUNT(*) as total_staff FROM users WHERE user_type = 'staff'";
$result = mysqli_query($conn, $sql);
$total_staff = mysqli_fetch_assoc($result)['total_staff'];

// Fetch the total number of students
$sql = "SELECT COUNT(*) as total_students FROM users WHERE user_type = 'student'";
$result = mysqli_query($conn, $sql);
$total_students = mysqli_fetch_assoc($result)['total_students'];

// Fetch the total number of staff added as mentors
$sql = "SELECT COUNT(*) as total_mentors FROM staff_student_allocation WHERE role = 'mentor-mentee'";
$result = mysqli_query($conn, $sql);
$total_mentors = mysqli_fetch_assoc($result)['total_mentors'];

// Fetch the total number of students added as mentees
$sql = "SELECT COUNT(*) as total_mentees FROM staff_student_allocation WHERE role = 'mentor-mentee'";
$result = mysqli_query($conn, $sql);
$total_mentees = mysqli_fetch_assoc($result)['total_mentees'];

// Fetch the total number of staff added as tutors
$sql = "SELECT COUNT(*) as total_tutors FROM staff_student_allocation WHERE role = 'tutor-student'";
$result = mysqli_query($conn, $sql);
$total_tutors = mysqli_fetch_assoc($result)['total_tutors'];

// Fetch leave requests for the admin to approve
$leave_requests_sql = "SELECT la.id, u.username, la.leave_type, la.from_date, la.to_date, la.description, la.status 
                       FROM leave_applications la
                       JOIN users u ON la.student_id = u.id
                       WHERE la.status IN ('approved_by_tutor', 'approved_by_admin', 'rejected_by_admin', 'pending')";
$leave_requests_result = mysqli_query($conn, $leave_requests_sql);
$leave_requests = mysqli_fetch_all($leave_requests_result, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="external_styles.css">
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
        <h2>Admin Dashboard</h2>
        <div class="dashboard-stats">
            <div class="stat-box">
                <h3>Added Staff</h3>
                <p><?php echo $total_staff; ?></p>
            </div>
            <div class="stat-box">
                <h3>Added Students</h3>
                <p><?php echo $total_students; ?></p>
            </div>
            <div class="stat-box">
                <h3>Staff Added as Mentors</h3>
                <p><?php echo $total_mentors; ?></p>
            </div>
            <div class="stat-box">
                <h3>Students Added as Mentees</h3>
                <p><?php echo $total_mentees; ?></p>
            </div>
            <div class="stat-box">
                <h3>Staff Added as Tutors</h3>
                <p><?php echo $total_tutors; ?></p>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-container">
                <h3>Add Staff</h3>
                <form action="addStaff.php" method="POST">
                    <div class="form-group">
                        <label for="staff_username">Username:</label>
                        <input type="text" id="staff_username" name="staff_username" required>
                    </div>
                    <div class="form-group">
                        <label for="staff_email">Email:</label>
                        <input type="email" id="staff_email" name="staff_email" required>
                    </div>
                    <div class="form-group">
                        <label for="staff_password">Password:</label>
                        <input type="password" id="staff_password" name="staff_password" required>
                    </div>
                    <button type="submit">Add Staff</button>
                </form>
                <button onclick="window.location.href='viewStaff.php'">View Staff</button>
            </div>
            <div class="form-container">
                <h3>Add Student</h3>
                <form action="addStudent.php" method="POST">
                    <div class="form-group">
                        <label for="student_username">Username:</label>
                        <input type="text" id="student_username" name="student_username" required>
                    </div>
                    <div class="form-group">
                        <label for="student_rollno">Roll Number:</label>
                        <input type="text" id="student_rollno" name="student_rollno" required>
                    </div>
                   
                    <div class="form-group">
                        <label for="student_email">Email:</label>
                        <input type="email" id="student_email" name="student_email" required>
                    </div>
                    <div class="form-group">
                        <label for="student_password">Password:</label>
                        <input type="password" id="student_password" name="student_password" required>
                    </div>
                   
                    <button type="submit">Add Student</button>
                </form>
                <button onclick="window.location.href='viewStudents.php'">View Students</button>
            </div>
        </div>
        <div class="form-row">
            <div class="form-container">
                <h3>Add Mentee for Mentor</h3>
                <form action="addMenteeForMentor.php" method="POST">
                    <div class="form-group">
                        <label for="mentor_id_single">Mentor:</label>
                        <select id="mentor_id_single" name="mentor_id_single" required>
                            <!-- Options will be populated dynamically from the database -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mentee_id_single">Mentee:</label>
                        <select id="mentee_id_single" name="mentee_id_single" required>
                            <!-- Options will be populated dynamically from the database -->
                        </select>
                    </div>
                    <button type="submit">Add Mentee</button>
                </form>
                <button onclick="window.location.href='viewMentorMentee.php'">View Mentor-Mentee Allocations</button>
            </div>
            <div class="form-container">
                <h3>Add Student for Tutor</h3>
                <form action="addStudentForTutor.php" method="POST">
                    <div class="form-group">
                        <label for="tutor_id_single">Tutor:</label>
                        <select id="tutor_id_single" name="tutor_id_single" required>
                            <!-- Options will be populated dynamically from the database -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="student_id_single">Student:</label>
                        <select id="student_id_single" name="student_id_single" required>
                            <!-- Options will be populated dynamically from the database -->
                        </select>
                    </div>
                    <button type="submit">Add Student</button>
                </form>
                <button onclick="window.location.href='viewTutorStudent.php'">View Tutor-Student Allocations</button>
            </div>
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
    <script src="scripts.js"></script>
    <script src="external_scripts.js"></script>
</body>
</html>
