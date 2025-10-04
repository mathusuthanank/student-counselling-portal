<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    // Delete related entries in staff_student_allocation table
    $sql_allocation = "DELETE FROM staff_student_allocation WHERE staff_id = '$id'";
    mysqli_query($conn, $sql_allocation);

    // Delete staff
    $sql = "DELETE FROM users WHERE id = '$id' AND user_type = 'staff'";
    if (mysqli_query($conn, $sql)) {
        echo "Staff deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT id, username, email,programme_name FROM users WHERE user_type = 'staff'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>
    <link rel="stylesheet" href="viewStaff.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Student Counselling Portal</h1>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
    <div class='table-container'>
        <h2>Staff List</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Department</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['programme_name'] . "</td>";
                echo "<td>
                        <form method='POST' action=''>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <button type='submit'>Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <?php mysqli_close($conn); ?>
</body>
</html>
