<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    if ($user_type == 'admin' && $username == 'Mathusuthanan' && $password == 'admin@123') {
        header('Location: admin_dashboard.php');
        exit();
    }

    $sql = "SELECT * FROM users WHERE username = '$username' AND user_type = '$user_type'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        if ($user_type == 'staff') {
            $_SESSION['staff_id'] = $user['id'];
            header('Location: staff_dashboard.php');
            exit();
        } elseif ($user_type == 'student') {
            $_SESSION['student_id'] = $user['id'];
            header('Location: student_dashboard.php');
            exit();
        }
    } else {
        echo "Invalid credentials or user type.";
    }

    mysqli_close($conn);
}
?>
