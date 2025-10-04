<?php
include 'db_connection.php';

$sql = "SELECT * FROM some_table"; // Replace with your actual query
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode(['content' => json_encode($data)]);
?>
