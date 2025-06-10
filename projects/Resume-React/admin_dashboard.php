<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    .dashboard-btn {
      width: 200px;
      margin: 10px;
    }
    .dashboard-container {
      margin-top: 50px;
      display: flex;
      justify-content: center;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="admin_change_password.php">Change Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Dashboard Buttons -->
  <div class="container dashboard-container">
    <a href="manage_users.php" class="btn btn-primary dashboard-btn">Manage Users</a>
    <a href="manage_templates.php" class="btn btn-success dashboard-btn">Manage Templates</a>
  </div>
</body>
</html>
