<?php
session_start();
include 'includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve inputs
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate fields
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = "Please fill in all fields.";
    } elseif ($new_password !== $confirm_password) {
        $message = "New password and confirm password do not match.";
    } else {
        $admin_id = $_SESSION['admin_id'];
        // Get current hashed password from the database
        $sql = "SELECT password FROM admin WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();
            // Verify the current password entered by admin
            if (password_verify($current_password, $admin['password'])) {
                // Hash the new password
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                // Update the new password in the database
                $sql_update = "UPDATE admin SET password = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $hashed_new_password, $admin_id);
                if ($stmt_update->execute()) {
                    $message = "Password changed successfully.";
                } else {
                    $message = "Error updating password: " . $conn->error;
                }
                $stmt_update->close();
            } else {
                $message = "Current password is incorrect.";
            }
        } else {
            $message = "Admin record not found.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Change Password</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
      body {
          background: #f8f9fa;
          font-family: sans-serif;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
      }
      .container {
          background: #fff;
          padding: 30px;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0,0,0,0.1);
          max-width: 500px;
          width: 100%;
      }
  </style>
</head>
<body>
  <div class="container">
    <h2>Change Password</h2>
    <?php if($message != ""): ?>
      <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="form-group">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Change Password</button>
      <a href="manage_templates.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>
