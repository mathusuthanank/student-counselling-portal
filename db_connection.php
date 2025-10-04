<?php
$servername = "localhost";
$username = "root";
$password = ""; // Ensure this is the correct password for your MySQL server
$dbname = "student_counselling_portal";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
