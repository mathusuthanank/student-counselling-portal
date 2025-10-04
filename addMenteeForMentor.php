<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mentor_id = $_POST['mentor_id_single'];
    $mentee_id = $_POST['mentee_id_single'];

    $sql = "INSERT INTO staff_student_allocation (staff_id, student_id, role) VALUES ('$mentor_id', '$mentee_id', 'mentor-mentee')";
    if (mysqli_query($conn, $sql)) {
        echo "Mentee added for mentor successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
