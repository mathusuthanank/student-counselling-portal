<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['staff_username'];
    $email = $_POST['staff_email'];
    $password = password_hash($_POST['staff_password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password, user_type) VALUES ('$username', '$email', '$password', 'staff')";
    if (mysqli_query($conn, $sql)) {
        echo "New staff added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
