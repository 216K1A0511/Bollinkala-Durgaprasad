<?php
session_start();
include 'includes/db.php';

// Check if the current user is an admin; adjust this check as needed.
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email    = $conn->real_escape_string(trim($_POST['email']));
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill in all required fields.";
    } else {
        // Check if a user with the same username or email already exists
        $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            $error = "A user with that username or email already exists.";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the users table
            $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
            if ($conn->query($insertQuery) === TRUE) {
                $success = "User created successfully.";
            } else {
                $error = "Error creating user: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Create User</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container mt-4">
        <h1>Create New User</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form action="admin_create_user.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group mt-2">
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group mt-2">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create User</button>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
