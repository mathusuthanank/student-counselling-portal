<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT leave_type, from_date, to_date, description, status FROM leave_applications WHERE student_id = '$student_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$leave_requests = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status on Leave and OD</title>
    <link rel="stylesheet" href="status.css">
</head>
<body>
<header>
    <h1>Student Counselling Portal</h1>
    <nav>
        <ul>
            <li><a href="student_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<div class="dashboard-container">
    <h2>Status on Leave and OD</h2>
    <div class="leave-requests">
        <table>
            <thead>
                <tr>
                    <th>Leave Type</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leave_requests as $request): ?>
                    <tr>
                        <td><?php echo $request['leave_type']; ?></td>
                        <td><?php echo $request['from_date']; ?></td>
                        <td><?php echo $request['to_date']; ?></td>
                        <td><?php echo $request['description']; ?></td>
                        <td><?php echo $request['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
