<?php
// Start the session
session_start();

// Include the database configuration file
include_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - Student Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('photo/student.jpg'); /* Replace 'your_background_image.jpg' with the path to your image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Do not repeat the background image */
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .section p {
            margin: 5px 0;
        }

        .education-item,
        .experience-item,
        .skill-item,
        .document-item {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Student Profile</h2>
        <?php
        // Fetch student's personal details from the database based on student ID from session
        if(isset($_SESSION['student_id'])) {
            $student_id = $_SESSION['student_id'];

            // Fetch student's personal details
            $query = $conn->prepare("SELECT * FROM students WHERE student_id = :student_id");
            $query->execute(array(':student_id' => $student_id));
            $student = $query->fetch(PDO::FETCH_ASSOC);

            // Display personal details
            if($student) {
                echo "<div class='section'>";
                echo "<h3 class='section-title'>Personal Details</h3>";
                echo "<p><strong>Name:</strong> {$student['first_name']} {$student['last_name']}</p>";
                echo "<p><strong>Email:</strong> {$student['email']}</p>";
                echo "<p><strong>Phone Number:</strong> {$student['phone_number']}</p>";
                echo "<p><strong>Emergency Contact:</strong> {$student['emergency_contact_name']} ({$student['emergency_contact_phone']})</p>";
                echo "<p><strong>Address:</strong> {$student['address']}</p>";
                echo "<p><strong>Date of Birth:</strong> {$student['date_of_birth']}</p>";
                echo "</div>";
            } else {
                echo "<p>Student not found!</p>";
            }

            // Fetch and display course enrollment details
            echo "<div class='section'>";
            echo "<h3 class='section-title'>Course Enrollment</h3>";
            $query_course = $conn->prepare("SELECT * FROM student_courses WHERE student_id = :student_id");
            $query_course->execute(array(':student_id' => $student_id));
            $courses = $query_course->fetchAll(PDO::FETCH_ASSOC);
            if ($courses) {
                foreach ($courses as $course) {
                    echo "<div class='course-item'>";
                    echo "<p><strong>Course ID:</strong> {$course['course_id']}</p>";
                    // Fetch and display course details if needed
                    echo "</div>";
                }
            } else {
                echo "<p>No courses enrolled.</p>";
            }
            echo "</div>";

            // Fetch and display education details
            echo "<div class='section'>";
            echo "<h3 class='section-title'>Education</h3>";
            $query_education = $conn->prepare("SELECT * FROM education WHERE student_id = :student_id");
            $query_education->execute(array(':student_id' => $student_id));
            $educations = $query_education->fetchAll(PDO::FETCH_ASSOC);
            if ($educations) {
                foreach ($educations as $education) {
                    echo "<div class='education-item'>";
                    echo "<p><strong>Degree:</strong> {$education['degree']}</p>";
                    echo "<p><strong>Major:</strong> {$education['major']}</p>";
                    echo "<p><strong>Institution:</strong> {$education['institution']}</p>";
                    echo "<p><strong>Duration:</strong> {$education['start_date']} - {$education['end_date']}</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No education details found.</p>";
            }
            echo "</div>";

            // Fetch and display skills details
            echo "<div class='section'>";
            echo "<h3 class='section-title'>Skills</h3>";
            $query_skills = $conn->prepare("SELECT * FROM skills WHERE student_id = :student_id");
            $query_skills->execute(array(':student_id' => $student_id));
            $skills = $query_skills->fetchAll(PDO::FETCH_ASSOC);
            if ($skills) {
                foreach ($skills as $skill) {
                    echo "<div class='skill-item'>";
                    echo "<p><strong>Skill:</strong> {$skill['skill_name']}</p>";
                    echo "<p><strong>Proficiency:</strong> {$skill['proficiency']}</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No skills found.</p>";
            }
            echo "</div>";

            // Fetch and display documents details
            echo "<div class='section'>";
            echo "<h3 class='section-title'>Documents</h3>";
            $query_documents = $conn->prepare("SELECT * FROM documents WHERE student_id = :student_id");
            $query_documents->execute(array(':student_id' => $student_id));
            $documents = $query_documents->fetchAll(PDO::FETCH_ASSOC);
            if ($documents) {
                foreach ($documents as $document) {
                    echo "<div class='document-item'>";
                    echo "<p><strong>Title:</strong> {$document['title']}</p>";
                    echo "<p><strong>Description:</strong> {$document['description']}</p>";
                    echo "<p><strong>File:</strong> <a href='{$document['file_path']}' target='_blank'>Download</a></p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No documents found.</p>";
            }
            echo "</div>";
        } else {
            echo "<p>Student ID not provided!</p>";
        }
        ?>
    </div>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
