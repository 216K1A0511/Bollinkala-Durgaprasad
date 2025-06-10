<?php
session_start();
include 'includes/db.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: manage_users.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Query admin table for static admin credentials
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        // For production, use password_verify() if using hashed passwords.
        if ($admin['password'] === $password) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: manage_templates.php");
            exit;
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      body {
          background: url('imgs/ideal_photo.jpg') no-repeat center center fixed;
          background-size: cover;
          margin: 0;
          padding-top: 70px; /* To prevent content being hidden under fixed navbar */
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
      }
      .login-container {
          background: rgba(255, 255, 255, 0.9);
          padding: 2rem;
          border-radius: 8px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          max-width: 400px;
          width: 100%;
      }
      .login-container h2 {
          margin-bottom: 1.5rem;
      }
      .btn-custom {
          background-color: #007bff;
          color: #fff;
      }
      .btn-custom:hover {
          background-color: #0056b3;
      }
      /* Fixed Navbar */
      .navbar.fixed-top {
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      }
  </style>
</head>
<body>
  <!-- Fixed Navbar with Back Button -->
  <nav class="navbar navbar-light bg-light fixed-top">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">Welcome to Admin Login page</span>
      <button class="btn btn-outline-primary" onclick="window.location.href='login1.php'">Back</button>
    </div>
  </nav>
  
  <div class="login-container">
    <h2 class="text-center">Admin Login</h2>
    <?php if ($error != "") { echo '<div class="alert alert-danger">'.$error.'</div>'; } ?>
    <form method="POST" action="">
      <div class="mb-3">
         <label for="username" class="form-label">Username:</label>
         <input type="text" name="username" class="form-control" required autocomplete="off">
      </div>
      <div class="mb-3">
         <label for="password" class="form-label">Password:</label>
         <input type="password" name="password" class="form-control" required autocomplete="off">
      </div>
      <div class="d-grid">
         <button type="submit" class="btn btn-custom">Login</button>
      </div>
    </form>
  </div>
  
  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
