<?php
include 'db_connection.php';

$sql = "SELECT id, username FROM users WHERE user_type = 'student'";
$result = mysqli_query($conn, $sql);

$students = array();
while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}

echo json_encode($students);
mysqli_close($conn);
?>
