<?php
include 'db_connection.php';

if (!isset($_GET['mentor_id'])) {
    die("Mentor ID is required.");
}

$mentor_id = $_GET['mentor_id'];
$sql = "SELECT u.id, u.username FROM staff_student_allocation ssa JOIN users u ON ssa.student_id = u.id WHERE ssa.staff_id = ? AND ssa.role = 'mentor-mentee'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mentor_id);
$stmt->execute();
$result = $stmt->get_result();

$mentees = [];
while ($row = $result->fetch_assoc()) {
    $mentees[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($mentees);
