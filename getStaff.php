<?php
include 'db_connection.php';

$sql = "SELECT id, username FROM users WHERE user_type = 'staff'";
$result = mysqli_query($conn, $sql);

$staff = array();
while ($row = mysqli_fetch_assoc($result)) {
    $staff[] = $row;
}

echo json_encode($staff);
mysqli_close($conn);
?>
