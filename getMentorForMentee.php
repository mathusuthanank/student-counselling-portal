<?php
include 'db_connection.php';

if (!isset($_GET['mentee_id'])) {
    die("Mentee ID is required.");
}

$mentee_id = $_GET['mentee_id'];
$sql = "SELECT staff_id as mentor_id FROM staff_student_allocation WHERE student_id = ? AND role = 'mentor-mentee'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mentee_id);
$stmt->execute();
$result = $stmt->get_result();

$mentor = $result->fetch_assoc();

$stmt->close();
$conn->close();

echo json_encode($mentor);
?>
