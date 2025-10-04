<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="external_styles.css">
</head>
<body>
<header>
        <h1>Student Counselling Portal</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php">login</a></li>
            </ul>
        </nav>
    </header>
    <div class="login-container">
        <h2>Login</h2>
        <form action="loginController.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="user_type">User Type:</label>
                <select id="user_type" name="user_type" required>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <button type="submit">Login</button>
        </form>
        
    </div>
    <script src="scripts.js"></script>
    <script src="external_scripts.js"></script>
</body>
</html>