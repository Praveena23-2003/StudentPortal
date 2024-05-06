<?php
// Include the database configuration file
require_once 'config.php';

// Define variables and initialize with empty values
$email = $password = '';
$email_err = $password_err = '';

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        try {
            // Prepare a select statement
            $query = $conn->prepare("SELECT student_id, email, password FROM students WHERE email = :email");

            // Bind variables to the prepared statement as parameters
            $query->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if ($query->execute()) {
                // Check if email exists
                if ($query->rowCount() == 1) {
                    // Fetch row
                    $row = $query->fetch();
                    $stored_password = $row["password"];
                    if ($password === $stored_password) {
                        // Password is correct, start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["student_id"] = $row["student_id"];
                        $_SESSION["email"] = $email;

                        // Redirect user to dashboard
                        header("location: dashboard.php");
                        exit;
                    } else {
                        // Display an error message if password is not valid
                        $password_err = "The password you entered is not valid.";
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($query);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Close connection
    unset($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login - Student Portal</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
