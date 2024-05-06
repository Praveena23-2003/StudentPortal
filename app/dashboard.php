<?php
// Include the database configuration file
require_once 'config.php';

// Check if user is logged in, otherwise redirect to login page
session_start();

if (!isset($_SESSION["student_id"]) || empty($_SESSION["student_id"])) {
    header("location: login.php");
    exit;
}

// Logout logic
if (isset($_POST["logout"])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to index page
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('photo/dashboard.jpg'); /* Replace 'your_background_image.jpg' with the path to your image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Do not repeat the background image */
            background-color: #f2f2f2;

        }
        h2 {
            text-align: center;
            color: #333;
            margin-top: 50px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        li {
            margin: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 200px;
        }
        li:hover {
            transform: translateY(-5px);
        }
        a {
            display: block;
            padding: 20px;
            color: #333;
            text-decoration: none;
            text-align: center;
        }
        form.logout-form {
            text-align: center;
            margin-top: 20px;
        }
        button.logout-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button.logout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Welcome to Your Dashboard</h2>
    <ul>
        <li>
            <a href="course_enrollment.php">Course Enrollment</a>
        </li>
        <li>
            <a href="document_management.php">Document Management</a>
        </li>
        <li>
            <a href="student_profile.php">Student Profile Management</a>
        </li>
        <li>
            <a href="report.php">Report</a>
        </li>
    </ul>
    <form class="logout-form" method="post">
        <button type="submit" name="logout" class="logout-button">Logout</button>
    </form>
</body>
</html>
