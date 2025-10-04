<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['staff_id']) && !isset($_SESSION['admin_id'])) {
    header('Location: admin_dashboard.php');
    exit();
}

$user_id = isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : $_SESSION['admin_id'];

if (!isset($_POST['request_id']) || !isset($_POST['action'])) {
    echo "Invalid leave request ID or action.";
    exit();
}

$leave_id = $_POST['request_id'];
$action = $_POST['action'];

$sql = "SELECT student_id, status FROM leave_applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $leave_id);
$stmt->execute();
$result = $stmt->get_result();
$leave = $result->fetch_assoc();

if ($leave) {
    $student_id = $leave['student_id'];
    $current_status = $leave['status'];

    if ($action == 'approve') {
        if ($current_status == 'pending') {
            $new_status = 'approved_by_tutor';
            $message = "Your leave request has been approved by the tutor.";
            // Notify admin
            $admin_sql = "SELECT id FROM users WHERE user_type = 'admin' LIMIT 1";
            $admin_result = mysqli_query($conn, $admin_sql);
            $admin = mysqli_fetch_assoc($admin_result);
            if ($admin) {
                $admin_id = $admin['id'];
                $notification_sql = "INSERT INTO notifications (user_id, message) VALUES ('$admin_id', 'Leave request approved by tutor. <a href=\"respond_leave_request.php?leave_id=$leave_id&action=approve\">Approve</a> | <a href=\"respond_leave_request.php?leave_id=$leave_id&action=reject\">Reject</a>')";
                mysqli_query($conn, $notification_sql);
            }
        } elseif ($current_status == 'approved_by_tutor') {
            $new_status = 'approved_by_admin';
            $message = "Your leave request has been approved by the admin.";
        }
    } else {
        if ($current_status == 'pending') {
            $new_status = 'rejected_by_tutor';
            $message = "Your leave request has been rejected by the tutor.";
        } elseif ($current_status == 'approved_by_tutor') {
            $new_status = 'rejected_by_admin';
            $message = "Your leave request has been rejected by the admin.";
        }
    }

    $update_sql = "UPDATE leave_applications SET status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_status, $leave_id);
    $update_stmt->execute();

    $notification_sql = "INSERT INTO notifications (user_id, message) VALUES ('$student_id', '$message')";
    mysqli_query($conn, $notification_sql);

    echo "Response recorded successfully.";
} else {
    echo "Invalid leave request ID.";
}

$stmt->close();
$conn->close();
?>
