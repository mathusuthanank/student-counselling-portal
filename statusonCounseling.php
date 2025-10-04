<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch counseling sessions for the logged-in student
$sql = "SELECT cs.session_date, cs.session_time, cs.notes, cs.status, u.username as mentor_username 
        FROM counseling_sessions cs
        JOIN users u ON cs.mentor_id = u.id
        WHERE cs.mentee_id = '$student_id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$counseling_sessions = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status on Counseling</title>
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
<h2>Status on Counseling</h2>
<table>
    <thead>
        <tr>
            <th>Mentor Name</th>
            <th>Session Date</th>
            <th>Session Time</th>
            <th>Notes</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($counseling_sessions as $session) { ?>
            <tr>
                <td><?php echo $session['mentor_username']; ?></td>
                <td><?php echo $session['session_date']; ?></td>
                <td><?php echo $session['session_time']; ?></td>
                <td><?php echo $session['notes']; ?></td>
                <td><?php echo ucfirst($session['status']); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</body>
</html>
