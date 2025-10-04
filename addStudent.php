<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['student_username'];
    $email = $_POST['student_email'];
    $password = password_hash($_POST['student_password'], PASSWORD_BCRYPT);
    $rollno = $_POST['student_rollno'];

    $sql = "INSERT INTO users (username, email, password, user_type, rollno) VALUES ('$username', '$email', '$password', 'student', '$rollno')";
    if (mysqli_query($conn, $sql)) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
