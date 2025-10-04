<?php
include 'db_connection.php';

if (!isset($_GET['user_id'])) {
    die("User ID is required.");
}

$user_id = $_GET['user_id'];
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();

$stmt->close();
$conn->close();

echo json_encode($user);
?>
