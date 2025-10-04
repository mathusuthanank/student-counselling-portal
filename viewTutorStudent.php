<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "DELETE FROM staff_student_allocation WHERE id = '$id' AND role = 'tutor-student'";
    if (mysqli_query($conn, $sql)) {
        echo "Tutor-Student allocation deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT ssa.id, u1.username AS tutor_name, u2.username AS student_name 
        FROM staff_student_allocation ssa
        JOIN users u1 ON ssa.staff_id = u1.id
        JOIN users u2 ON ssa.student_id = u2.id
        WHERE ssa.role = 'tutor-student'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tutor-Student</title>
    <link rel="stylesheet" href="viewTutorStudent.css">
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
        <h2>Tutor-Student List</h2>
        <table>
            <thead>
                <tr>
                    <th>Tutor Name</th>
                    <th>Student Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['tutor_name'] . "</td>";
                    echo "<td>" . $row['student_name'] . "</td>";
                    echo "<td>
                            <form method='POST' action=''>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <button type='submit'>Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php mysqli_close($conn); ?>
</body>
</html>
