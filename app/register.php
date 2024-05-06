<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $emergency_contact_name = $_POST['emergency_contact_name'];
    $emergency_contact_phone = $_POST['emergency_contact_phone'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $password = $_POST['password'];
    $degree = $_POST['degree'];
    $major = $_POST['major'];
    $institution = $_POST['institution'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $skill_name = $_POST['skill_name'];
    $proficiency = $_POST['proficiency'];

    // Insert data into students table
    $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, email, phone_number, emergency_contact_name, emergency_contact_phone, address, date_of_birth, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $email, $phone_number, $emergency_contact_name, $emergency_contact_phone, $address, $date_of_birth, $password]);
    $student_id = $conn->lastInsertId();

    // Insert data into education table
    $stmt = $conn->prepare("INSERT INTO education (student_id, degree, major, institution, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$student_id, $degree, $major, $institution, $start_date, $end_date]);

    // Insert data into skills table
    $stmt = $conn->prepare("INSERT INTO skills (student_id, skill_name, proficiency) VALUES (?, ?, ?)");
    $stmt->execute([$student_id, $skill_name, $proficiency]);

    echo "Registration successful!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('photo/register.jpeg'); /* Background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 50px;
        }

        form {
            margin: auto;
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        textarea {
            height: 100px;
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <!-- Personal Information -->
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number">

        <label for="emergency_contact_name">Emergency Contact Name:</label>
        <input type="text" id="emergency_contact_name" name="emergency_contact_name">

        <label for="emergency_contact_phone">Emergency Contact Phone:</label>
        <input type="text" id="emergency_contact_phone" name="emergency_contact_phone">

        <label for="address">Address:</label>
        <textarea id="address" name="address"></textarea>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <!-- Education Information -->
        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree" required>

        <label for="major">Major:</label>
        <input type="text" id="major" name="major" required>

        <label for="institution">Institution:</label>
        <input type="text" id="institution" name="institution" required>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date">

        <!-- Skills Information -->
        <label for="skill_name">Skill Name:</label>
        <input type="text" id="skill_name" name="skill_name" required>

        <label for="proficiency">Proficiency:</label>
        <input type="text" id="proficiency" name="proficiency">

        <input type="submit" value="Register">
    </form>
</body>
</html>
