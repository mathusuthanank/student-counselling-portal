<?php
include 'db_connection.php';
session_start();

$student_id = $_SESSION['student_id'];
$sql = "SELECT username, email, rollno FROM users WHERE id = '$student_id' AND user_type = 'student'";
$result = mysqli_query($conn, $sql);
$student_profile = mysqli_fetch_assoc($result);

// Check if student details already exist
$details_sql = "SELECT * FROM student_details WHERE rollno = '{$student_profile['rollno']}'";
$details_result = mysqli_query($conn, $details_sql);
$student_details = mysqli_fetch_assoc($details_result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $gender = $_POST['gender'] ?? '';
    $rollno = $_POST['rollno'];
    $mobile_no = $_POST['mobile_no'];
    $whatsapp_no = $_POST['whatsapp_no'];
    $email_official = $_POST['email_official'];
    $email_personal = $_POST['email_personal'];
    $programme_name = $_POST['programme_name'];
    $medium_instruction = $_POST['medium_instruction'];
    $year_enrollment = $_POST['year_enrollment'];
    $batch = $_POST['batch'];
    $native_state = $_POST['native_state'];
    $scholarship_details = $_POST['scholarship_details'];
    $father_name = $_POST['father_name'];
    $father_contact = $_POST['father_contact'];
    $father_occupation = $_POST['father_occupation'];
    $mother_name = $_POST['mother_name'];
    $mother_contact = $_POST['mother_contact'];
    $mother_occupation = $_POST['mother_occupation'];
    $permanent_address = $_POST['permanent_address'];
    $communication_address = $_POST['communication_address'];
    $local_address = $_POST['local_address'];

    if ($student_details) {
        // Update existing details
        $sql = "UPDATE student_details SET 
                name='$name', gender='$gender', mobile_no='$mobile_no', whatsapp_no='$whatsapp_no', email_official='$email_official', email_personal='$email_personal', 
                programme_name='$programme_name', medium_instruction='$medium_instruction', year_enrollment='$year_enrollment', batch='$batch', native_state='$native_state', 
                scholarship_details='$scholarship_details', father_name='$father_name', father_contact='$father_contact', father_occupation='$father_occupation', 
                mother_name='$mother_name', mother_contact='$mother_contact', mother_occupation='$mother_occupation', permanent_address='$permanent_address', 
                communication_address='$communication_address', local_address='$local_address' 
                WHERE rollno='$rollno'";
    } else {
        // Insert new details
        $sql = "INSERT INTO student_details (name, gender, rollno, mobile_no, whatsapp_no, email_official, email_personal, programme_name, medium_instruction, year_enrollment, batch, native_state, scholarship_details, father_name, father_contact, father_occupation, mother_name, mother_contact, mother_occupation, permanent_address, communication_address, local_address) 
                VALUES ('$name', '$gender', '$rollno', '$mobile_no', '$whatsapp_no', '$email_official', '$email_personal', '$programme_name', '$medium_instruction', '$year_enrollment', '$batch', '$native_state', '$scholarship_details', '$father_name', '$father_contact', '$father_occupation', '$mother_name', '$mother_contact', '$mother_occupation', '$permanent_address', '$communication_address', '$local_address')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "Details submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details Form</title>
    <link rel="stylesheet" href="collectDetails.css">
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
    <div class="container">
        <h2>STUDENT DETAILS</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="<?php echo $student_profile['username']; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="male" <?php echo isset($student_details['gender']) && $student_details['gender'] == 'male' ? 'checked' : ''; ?> <?php echo $student_details ? 'disabled' : ''; ?>> Male</label>
                    <label><input type="radio" name="gender" value="female" <?php echo isset($student_details['gender']) && $student_details['gender'] == 'female' ? 'checked' : ''; ?> <?php echo $student_details ? 'disabled' : ''; ?>> Female</label>
                </div>
            </div>
            <div class="form-group">
                <label for="rollno">Register No</label>
                <input type="text" name="rollno" id="rollno" value="<?php echo $student_profile['rollno']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="mobile_no">Student Mobile No.</label>
                <input type="text" name="mobile_no" id="mobile_no" value="<?php echo isset($student_details['mobile_no']) ? $student_details['mobile_no'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="whatsapp_no">Whatsapp No.</label>
                <input type="text" name="whatsapp_no" id="whatsapp_no" value="<?php echo isset($student_details['whatsapp_no']) ? $student_details['whatsapp_no'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="email_official">Mentee Email ID (Official)</label>
                <input type="email" name="email_official" id="email_official" value="<?php echo $student_profile['email']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="email_personal">Mentee Email ID (Personal)</label>
                <input type="email" name="email_personal" id="email_personal" value="<?php echo isset($student_details['email_personal']) ? $student_details['email_personal'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="programme_name">Programme Name</label>
                <input type="text" name="programme_name" id="programme_name" value="<?php echo $student_profile['rollno']; ?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="medium_instruction">Medium of Instruction</label>
                <input type="text" name="medium_instruction" id="medium_instruction" value="<?php echo isset($student_details['medium_instruction']) ? $student_details['medium_instruction'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="year_enrollment">Year of Enrollment</label>
                <input type="text" name="year_enrollment" id="year_enrollment" value="<?php echo isset($student_details['year_enrollment']) ? $student_details['year_enrollment'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="batch">Batch</label>
                <input type="text" name="batch" id="batch" value="<?php echo isset($student_details['batch']) ? $student_details['batch'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="native_state">Native State</label>
                <input type="text" name="native_state" id="native_state" value="<?php echo isset($student_details['native_state']) ? $student_details['native_state'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="scholarship_details">Scholarship Details</label>
                <input type="text" name="scholarship_details" id="scholarship_details" value="<?php echo isset($student_details['scholarship_details']) ? $student_details['scholarship_details'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="father_name">Father's Name</label>
                <input type="text" name="father_name" id="father_name" value="<?php echo isset($student_details['father_name']) ? $student_details['father_name'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="father_contact">Father's Contact No.</label>
                <input type="text" name="father_contact" id="father_contact" value="<?php echo isset($student_details['father_contact']) ? $student_details['father_contact'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="father_occupation">Father's Occupation</label>
                <input type="text" name="father_occupation" id="father_occupation" value="<?php echo isset($student_details['father_occupation']) ? $student_details['father_occupation'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="mother_name">Mother's Name</label>
                <input type="text" name="mother_name" id="mother_name" value="<?php echo isset($student_details['mother_name']) ? $student_details['mother_name'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="mother_contact">Mother's Contact No.</label>
                <input type="text" name="mother_contact" id="mother_contact" value="<?php echo isset($student_details['mother_contact']) ? $student_details['mother_contact'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="mother_occupation">Mother's Occupation</label>
                <input type="text" name="mother_occupation" id="mother_occupation" value="<?php echo isset($student_details['mother_occupation']) ? $student_details['mother_occupation'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="permanent_address">Permanent Address</label>
                <input type="text" name="permanent_address" id="permanent_address" value="<?php echo isset($student_details['permanent_address']) ? $student_details['permanent_address'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="communication_address">Communication Address</label>
                <input type="text" name="communication_address" id="communication_address" value="<?php echo isset($student_details['communication_address']) ? $student_details['communication_address'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="local_address">Local Address (if applicable)</label>
                <input type="text" name="local_address" id="local_address" value="<?php echo isset($student_details['local_address']) ? $student_details['local_address'] : ''; ?>" <?php echo $student_details ? 'readonly' : ''; ?>>
            </div>
            <div class="form-actions">
                <?php if (!$student_details): ?>
                    <button type="submit" name="submit">Submit</button>
                <?php else: ?>
                    <button type="button" onclick="enableEditing()">Edit</button>
                    <button type="submit" name="submit" id="saveButton" style="display:none;">Save</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <script>
        function enableEditing() {
            const inputs = document.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.removeAttribute('readonly');
                input.removeAttribute('disabled');
            });
            document.getElementById('saveButton').style.display = 'inline-block';
        }
    </script>
</body>
</html>
