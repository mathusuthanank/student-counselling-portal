<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['staff_id'])) {
    header('Location: login.php');
    exit();
}

$session_id = $_POST['session_id'];
$action = $_POST['action'];

if ($action === 'accept') {
    $update_sql = "UPDATE counseling_sessions SET status = 'scheduled' WHERE id = '$session_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
} elseif ($action === 'reject') {
    $update_sql = "UPDATE counseling_sessions SET status = 'not scheduled' WHERE id = '$session_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo 'success';
    } else {
        echo 'error';
    }
}

mysqli_close($conn);
?>
