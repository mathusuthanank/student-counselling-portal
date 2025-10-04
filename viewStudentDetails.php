<?php
include 'db_connection.php';

if (!isset($_GET['rollno'])) {
    die("Student Roll No is required.");
}

$rollno = $_GET['rollno'];
$sql = "SELECT * FROM student_details WHERE rollno = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $rollno);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}

$student_details = $result->fetch_assoc();

if (!$student_details) {
    die("No details found for the given student Roll No.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="stylesheet" href="collectDetails.css">
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
    <h2>Student Details</h2>
    <div class="details-container">
        <div class="details-box">
            <p><strong>Name:</strong> <?php echo isset($student_details['name']) ? $student_details['name'] : 'N/A'; ?></p>
            <p><strong>Gender:</strong> <?php echo isset($student_details['gender']) ? $student_details['gender'] : 'N/A'; ?></p>
            <p><strong>Register No:</strong> <?php echo isset($student_details['rollno']) ? $student_details['rollno'] : 'N/A'; ?></p>
            <p><strong>Mobile No:</strong> <?php echo isset($student_details['mobile_no']) ? $student_details['mobile_no'] : 'N/A'; ?></p>
            <p><strong>Whatsapp No:</strong> <?php echo isset($student_details['whatsapp_no']) ? $student_details['whatsapp_no'] : 'N/A'; ?></p>
            <p><strong>Email (Official):</strong> <?php echo isset($student_details['email_official']) ? $student_details['email_official'] : 'N/A'; ?></p>
            <p><strong>Email (Personal):</strong> <?php echo isset($student_details['email_personal']) ? $student_details['email_personal'] : 'N/A'; ?></p>
            <p><strong>Programme Name:</strong> <?php echo isset($student_details['programme_name']) ? $student_details['programme_name'] : 'N/A'; ?></p>
            <p><strong>Medium of Instruction:</strong> <?php echo isset($student_details['medium_instruction']) ? $student_details['medium_instruction'] : 'N/A'; ?></p>
            <p><strong>Year of Enrollment:</strong> <?php echo isset($student_details['year_enrollment']) ? $student_details['year_enrollment'] : 'N/A'; ?></p>
            <p><strong>Batch:</strong> <?php echo isset($student_details['batch']) ? $student_details['batch'] : 'N/A'; ?></p>
            <p><strong>Native State:</strong> <?php echo isset($student_details['native_state']) ? $student_details['native_state'] : 'N/A'; ?></p>
            <p><strong>Scholarship Details:</strong> <?php echo isset($student_details['scholarship_details']) ? $student_details['scholarship_details'] : 'N/A'; ?></p>
            <p><strong>Father's Name:</strong> <?php echo isset($student_details['father_name']) ? $student_details['father_name'] : 'N/A'; ?></p>
            <p><strong>Father's Contact No:</strong> <?php echo isset($student_details['father_contact']) ? $student_details['father_contact'] : 'N/A'; ?></p>
            <p><strong>Father's Occupation:</strong> <?php echo isset($student_details['father_occupation']) ? $student_details['father_occupation'] : 'N/A'; ?></p>
            <p><strong>Mother's Name:</strong> <?php echo isset($student_details['mother_name']) ? $student_details['mother_name'] : 'N/A'; ?></p>
            <p><strong>Mother's Contact No:</strong> <?php echo isset($student_details['mother_contact']) ? $student_details['mother_contact'] : 'N/A'; ?></p>
            <p><strong>Mother's Occupation:</strong> <?php echo isset($student_details['mother_occupation']) ? $student_details['mother_occupation'] : 'N/A'; ?></p>
            <p><strong>Permanent Address:</strong> <?php echo isset($student_details['permanent_address']) ? $student_details['permanent_address'] : 'N/A'; ?></p>
            <p><strong>Communication Address:</strong> <?php echo isset($student_details['communication_address']) ? $student_details['communication_address'] : 'N/A'; ?></p>
            <p><strong>Local Address:</strong> <?php echo isset($student_details['local_address']) ? $student_details['local_address'] : 'N/A'; ?></p>
        </div>
    </div>
</body>
</html>
