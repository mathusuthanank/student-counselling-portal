<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tutor_id = $_POST['tutor_id_single'];
    $student_id = $_POST['student_id_single'];

    $sql = "INSERT INTO staff_student_allocation (staff_id, student_id, role) VALUES ('$tutor_id', '$student_id', 'tutor-student')";
    if (mysqli_query($conn, $sql)) {
        echo "Student added for tutor successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
