<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
require_once('includes/db.php');

$message = "";
$edit_mode = false;
$edit_user = [
    'id' => '',
    'username' => '',
    'email' => ''
];

// ------------------------
// Process User Deletion
// ------------------------
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $sql_delete = "DELETE FROM users WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    $stmt_delete->execute();
    $stmt_delete->close();
    header("Location: manage_users.php");
    exit();
}

// ------------------------
// Process POST Requests (Add/Edit)
// ------------------------
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Edit existing user
        $edit_id = intval($_POST['edit_id']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        if (!empty($password)) {
            $sql_update = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sssi", $username, $email, $password, $edit_id);
        } else {
            $sql_update = "UPDATE users SET username = ?, email = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssi", $username, $email, $edit_id);
        }
        
        if ($stmt_update->execute()) {
            $message = "User updated successfully.";
        } else {
            $message = "Error updating user: " . $conn->error;
        }
        $stmt_update->close();
    } else {
        // Add new user
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $username, $email, $password);
        
        if ($stmt_insert->execute()) {
            $message = "User added successfully.";
        } else {
            $message = "Error adding user: " . $conn->error;
        }
        $stmt_insert->close();
    }
}

// ------------------------
// Load user data for editing if needed
// ------------------------
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $sql_edit = "SELECT id, username, email FROM users WHERE id = ?";
    $stmt_edit = $conn->prepare($sql_edit);
    $stmt_edit->bind_param("i", $edit_id);
    $stmt_edit->execute();
    $result_edit = $stmt_edit->get_result();
    if ($result_edit->num_rows == 1) {
        $edit_user = $result_edit->fetch_assoc();
        $edit_mode = true;
    }
    $stmt_edit->close();
}

// ------------------------
// Retrieve all users for display
// ------------------------
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    .section-title { margin-top: 40px; border-bottom: 2px solid #ccc; padding-bottom: 10px; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="manage_templates.php">Manage Templates</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_change_password.php">Change Password</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>
  
  <div class="container mt-4">
    <h1>User Management</h1>
    <?php if($message != ""): ?>
      <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <!-- User Form: Add/Edit User -->
    <div class="card mb-4">
      <div class="card-header">
        <?php echo $edit_mode ? "Edit User" : "Add New User"; ?>
      </div>
      <div class="card-body">
        <form method="POST" action="manage_users.php<?php echo $edit_mode ? '?edit=' . $edit_user['id'] : ''; ?>">
          <?php if($edit_mode): ?>
            <input type="hidden" name="edit_id" value="<?php echo $edit_user['id']; ?>">
          <?php endif; ?>
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" required value="<?php echo htmlspecialchars($edit_user['username']); ?>">
          </div>
          <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($edit_user['email']); ?>">
          </div>
          <div class="form-group">
            <label for="password">
              <?php echo $edit_mode ? "New Password (leave blank to keep unchanged):" : "Password:"; ?>
            </label>
            <input type="password" name="password" class="form-control" <?php echo $edit_mode ? "" : "required"; ?>>
          </div>
          <button type="submit" class="btn btn-primary"><?php echo $edit_mode ? "Update User" : "Add User"; ?></button>
          <?php if($edit_mode): ?>
            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
          <?php endif; ?>
        </form>
      </div>
    </div>
    
    <!-- User List Table -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo htmlspecialchars($row['username']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td>
                <a href="manage_users.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="manage_users.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4">No users found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
