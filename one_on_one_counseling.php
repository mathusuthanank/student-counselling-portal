<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['staff_id']) && !isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['staff_id'])) {
    $user_id = $_SESSION['staff_id'];
    $user_type = 'staff';
} else {
    $user_id = $_SESSION['student_id'];
    $user_type = 'student';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mentor_username = $_POST['mentor_username'] ?? null;
    $mentee_username = $_POST['mentee_username'] ?? null;
    $session_date = $_POST['session_date'];
    $session_time = $_POST['session_time'];
    $notes = $_POST['reason'];

    if ($mentor_username && $mentee_username) {
        // Get mentor_id and mentee_id from usernames
        $mentor_check_sql = "SELECT id FROM users WHERE username = '$mentor_username' AND user_type = 'staff'";
        $mentee_check_sql = "SELECT id FROM users WHERE username = '$mentee_username' AND user_type = 'student'";
        $mentor_check_result = mysqli_query($conn, $mentor_check_sql);
        $mentee_check_result = mysqli_query($conn, $mentee_check_sql);

        if (mysqli_num_rows($mentor_check_result) > 0 && mysqli_num_rows($mentee_check_result) > 0) {
            $mentor_id = mysqli_fetch_assoc($mentor_check_result)['id'];
            $mentee_id = mysqli_fetch_assoc($mentee_check_result)['id'];

            $sql = "INSERT INTO counseling_sessions (mentor_id, mentee_id, session_date, session_time, notes, status) VALUES ('$mentor_id', '$mentee_id', '$session_date', '$session_time', '$notes', 'pending')";
            if (mysqli_query($conn, $sql)) {
                // Send notification to staff dashboard
                $notification_sql = "INSERT INTO notifications (user_id, message) VALUES ('$mentor_id', 'New counseling session scheduled with $mentee_username on $session_date at $session_time. <a href=\"respond_session.php?session_id=" . mysqli_insert_id($conn) . "&action=accept\">Accept</a> | <a href=\"respond_session.php?session_id=" . mysqli_insert_id($conn) . "&action=reject\">Reject</a>')";
                mysqli_query($conn, $notification_sql);

                echo "Counseling session scheduled successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Invalid mentor or mentee username.";
        }
    } else {
        echo "Mentor username and Mentee username are required.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One-on-One Counseling</title>
    <link rel="stylesheet" href="one.css">
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
    <h2>One-on-One Counselling</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="mentor_username">Mentor</label>
            <input type="text" id="mentor_username" name="mentor_username" readonly>
        </div>
        <div class="form-group">
            <label for="mentee_username">Mentee</label>
            <input type="text" id="mentee_username" name="mentee_username" readonly>
        </div>
        <div class="form-group">
            <label for="session_date">Session Date</label>
            <input type="date" id="session_date" name="session_date" required>
        </div>
        <div class="form-group">
            <label for="session_time">Session Time</label>
            <input type="time" id="session_time" name="session_time" required>
        </div>
        <div class="form-group">
            <label for="reason">Reason</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>
        </div>
        <div class="form-actions">
            <button type="submit">Schedule Session</button>
        </div>
    </form>
   
    <script src="external_scripts.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            autofillMentorAndMentee();
        });

        function autofillMentorAndMentee() {
            const mentorInput = document.getElementById('mentor_username');
            const menteeInput = document.getElementById('mentee_username');
            const userType = '<?php echo $user_type; ?>';
            const userId = '<?php echo $user_id; ?>';

            if (userType === 'staff') {
                fetch(`getUsername.php?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        mentorInput.value = data.username;
                    });

                // Fetch the mentees assigned to this mentor
                fetch(`getMenteesForMentor.php?mentor_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            menteeInput.value = data[0].username; // Autofill the first mentee
                        }
                    });
            } else if (userType === 'student') {
                fetch(`getUsername.php?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        menteeInput.value = data.username;
                    });

                // Fetch the mentor assigned to this mentee
                fetch(`getMentorForMentee.php?mentee_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.mentor_id) {
                            fetch(`getUsername.php?user_id=${data.mentor_id}`)
                                .then(response => response.json())
                                .then(data => {
                                    mentorInput.value = data.username;
                                });
                        }
                    });
            }
        }
    </script>
</body>
</html>
