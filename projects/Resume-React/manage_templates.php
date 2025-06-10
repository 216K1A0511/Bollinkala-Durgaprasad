<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
require_once('includes/db.php');

$template_message = "";
$template_edit_mode = false;
$edit_template = [
    'id' => '',
    'template_name' => '',
    'file_path' => '',
    'preview_image' => ''
];

// Function to reorder IDs and reset auto_increment
function reorderTemplates($conn) {
    // Reset a user-defined variable
    $conn->query("SET @count = 0");
    // Update all IDs to be sequential based on the current order
    $conn->query("UPDATE templates SET id = (@count:=@count+1) ORDER BY id");
    // Reset the auto_increment to 1 so that next insert gets the lowest available number
    $conn->query("ALTER TABLE templates AUTO_INCREMENT = 1");
}

// ------------------------
// Process Template Deletion
// ------------------------
if (isset($_GET['template_delete'])) {
    $template_delete_id = intval($_GET['template_delete']);
    // Retrieve file paths
    $sql_get_template = "SELECT file_path, preview_image FROM templates WHERE id = ?";
    $stmt_get = $conn->prepare($sql_get_template);
    $stmt_get->bind_param("i", $template_delete_id);
    $stmt_get->execute();
    $result_get = $stmt_get->get_result();
    if ($result_get->num_rows > 0) {
        $template_row = $result_get->fetch_assoc();
        $file_path = $template_row['file_path'];
        $preview_path = $template_row['preview_image'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        if (!empty($preview_path) && file_exists($preview_path)) {
            unlink($preview_path);
        }
        $sql_delete_template = "DELETE FROM templates WHERE id = ?";
        $stmt_delete_template = $conn->prepare($sql_delete_template);
        $stmt_delete_template->bind_param("i", $template_delete_id);
        $stmt_delete_template->execute();
        $stmt_delete_template->close();
        $template_message = "Template deleted successfully.";
    }
    $stmt_get->close();

    // Reorder IDs after deletion
    reorderTemplates($conn);

    header("Location: manage_templates.php");
    exit();
}

// ------------------------
// Process GET parameter for template edit
// ------------------------
if (isset($_GET['template_edit'])) {
    $template_edit_id = intval($_GET['template_edit']);
    $sql_edit_template = "SELECT * FROM templates WHERE id = ?";
    $stmt_edit_template = $conn->prepare($sql_edit_template);
    $stmt_edit_template->bind_param("i", $template_edit_id);
    $stmt_edit_template->execute();
    $result_edit_template = $stmt_edit_template->get_result();
    if ($result_edit_template->num_rows == 1) {
        $edit_template = $result_edit_template->fetch_assoc();
        $template_edit_mode = true;
    }
    $stmt_edit_template->close();
}

// ------------------------
// Process POST Requests
// ------------------------
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Template update (edit mode)
    if (isset($_POST['update_template'])) {
        $template_id = intval($_POST['template_id']);
        $template_name = trim($_POST['template_name']);
        $safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $template_name);
        $uploadDir = "template_files/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $updateTemplateFile = false;
        $updatePreviewImage = false;
        
        // Check if a new template file was uploaded
        if (isset($_FILES['template_file']) && $_FILES['template_file']['error'] == 0) {
            $fileInfo = pathinfo($_FILES['template_file']['name']);
            $ext = strtolower($fileInfo['extension'] ?? '');
            if ($ext !== 'html' && $ext !== 'htm') {
                $template_message = "Error: Only HTML files are allowed for templates.";
            } else {
                // For template files, you can use the safe name
                $newFileName = $safeName . ".html";
                $destination = $uploadDir . $newFileName;
                if (move_uploaded_file($_FILES['template_file']['tmp_name'], $destination)) {
                    if (!empty($_POST['old_file']) && file_exists($_POST['old_file'])) {
                        unlink($_POST['old_file']);
                    }
                    $updateTemplateFile = true;
                } else {
                    $template_message = "Error moving the uploaded template file.";
                }
            }
        }
        
        // Check if a new preview image was uploaded
        if (isset($_FILES['preview_image']) && $_FILES['preview_image']['error'] == 0) {
            $imgInfo = pathinfo($_FILES['preview_image']['name']);
            $imgExt = strtolower($imgInfo['extension'] ?? '');
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imgExt, $allowed)) {
                $template_message = "Error: Only JPG, JPEG, PNG, or GIF files are allowed for preview images.";
            } else {
                $imgUploadDir = "template_files/template_img/";
                if (!is_dir($imgUploadDir)) {
                    mkdir($imgUploadDir, 0755, true);
                }
                // Append a unique identifier to the preview image filename
                $uniqueSuffix = time();
                $imgFileName = $safeName . "_" . $uniqueSuffix . "." . $imgExt;
                $previewPath = $imgUploadDir . $imgFileName;
                if (move_uploaded_file($_FILES['preview_image']['tmp_name'], $previewPath)) {
                    if (!empty($_POST['old_preview']) && file_exists($_POST['old_preview'])) {
                        unlink($_POST['old_preview']);
                    }
                    $updatePreviewImage = true;
                } else {
                    $template_message = "Error moving the preview image file.";
                }
            }
        }
        
        // Build the update query based on uploaded files
        if ($updateTemplateFile && $updatePreviewImage) {
            $sql_update_template = "UPDATE templates SET template_name = ?, file_path = ?, preview_image = ? WHERE id = ?";
            $stmt_update_template = $conn->prepare($sql_update_template);
            $stmt_update_template->bind_param("sssi", $template_name, $destination, $previewPath, $template_id);
        } elseif ($updateTemplateFile) {
            $sql_update_template = "UPDATE templates SET template_name = ?, file_path = ? WHERE id = ?";
            $stmt_update_template = $conn->prepare($sql_update_template);
            $stmt_update_template->bind_param("ssi", $template_name, $destination, $template_id);
        } elseif ($updatePreviewImage) {
            $sql_update_template = "UPDATE templates SET template_name = ?, preview_image = ? WHERE id = ?";
            $stmt_update_template = $conn->prepare($sql_update_template);
            $stmt_update_template->bind_param("ssi", $template_name, $previewPath, $template_id);
        } else {
            $sql_update_template = "UPDATE templates SET template_name = ? WHERE id = ?";
            $stmt_update_template = $conn->prepare($sql_update_template);
            $stmt_update_template->bind_param("si", $template_name, $template_id);
        }
        if (isset($stmt_update_template) && $stmt_update_template->execute()) {
            $template_message = "Template updated successfully.";
        } else {
            $template_message = "Error updating template: " . $conn->error;
        }
        $stmt_update_template->close();

        // Reorder IDs after update if needed
        reorderTemplates($conn);
    }
    // Template upload (new template)
    elseif (isset($_POST['upload_template'])) {
        if (isset($_FILES['template_file']) && $_FILES['template_file']['error'] == 0) {
            $template_name = trim($_POST['template_name']);
            $safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $template_name);
            $uploadDir = "template_files/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileInfo = pathinfo($_FILES['template_file']['name']);
            $ext = strtolower($fileInfo['extension'] ?? '');
            if ($ext !== 'html' && $ext !== 'htm') {
                $template_message = "Error: Only HTML files are allowed for templates.";
            } else {
                $newFileName = $safeName . ".html";
                $destination = $uploadDir . $newFileName;
                if (move_uploaded_file($_FILES['template_file']['tmp_name'], $destination)) {
                    // Process preview image upload (optional)
                    $previewPath = "";
                    if (isset($_FILES['preview_image']) && $_FILES['preview_image']['error'] == 0) {
                        $imgInfo = pathinfo($_FILES['preview_image']['name']);
                        $imgExt = strtolower($imgInfo['extension'] ?? '');
                        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                        if (!in_array($imgExt, $allowed)) {
                            $template_message = "Error: Only JPG, JPEG, PNG, or GIF files are allowed for preview images.";
                        } else {
                            $imgUploadDir = "template_files/template_img/";
                            if (!is_dir($imgUploadDir)) {
                                mkdir($imgUploadDir, 0755, true);
                            }
                            $uniqueSuffix = time();
                            $imgFileName = $safeName . "_" . $uniqueSuffix . "." . $imgExt;
                            $previewPath = $imgUploadDir . $imgFileName;
                            if (!move_uploaded_file($_FILES['preview_image']['tmp_name'], $previewPath)) {
                                $template_message = "Error moving the preview image file.";
                            }
                        }
                    }
                    $sql_insert_template = "INSERT INTO templates (template_name, file_path, preview_image) VALUES (?, ?, ?)";
                    $stmt_template = $conn->prepare($sql_insert_template);
                    $stmt_template->bind_param("sss", $template_name, $destination, $previewPath);
                    if ($stmt_template->execute()) {
                        $template_message = "Template uploaded successfully.";
                    } else {
                        $template_message = "Database error: " . $conn->error;
                    }
                    $stmt_template->close();
                } else {
                    $template_message = "Error moving the uploaded template file.";
                }
            }
        } else {
            $template_message = "Error: No template file uploaded or an upload error occurred.";
        }
        // Reorder IDs after insertion so that new entries fill gaps
        reorderTemplates($conn);
    }
}

// ------------------------
// Retrieve all templates for display
// ------------------------
$sql_templates = "SELECT * FROM templates ORDER BY id ASC";
$result_templates = $conn->query($sql_templates);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Templates</title>
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
        <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_change_password.php">Change Password</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>
  
  <div class="container mt-4">
    <h1>Template Management</h1>
    <?php if($template_message != ""): ?>
      <div class="alert alert-info"><?php echo $template_message; ?></div>
    <?php endif; ?>
    
    <!-- Template Form: Edit Mode or Upload New Template -->
    <?php if ($template_edit_mode): ?>
      <div class="card mb-4">
        <div class="card-header">Edit Template (ID: <?php echo $edit_template['id']; ?>)</div>
        <div class="card-body">
          <form method="POST" action="manage_templates.php?template_edit=<?php echo $edit_template['id']; ?>" enctype="multipart/form-data">
            <input type="hidden" name="update_template" value="1">
            <input type="hidden" name="template_id" value="<?php echo $edit_template['id']; ?>">
            <input type="hidden" name="old_file" value="<?php echo htmlspecialchars($edit_template['file_path']); ?>">
            <input type="hidden" name="old_preview" value="<?php echo htmlspecialchars($edit_template['preview_image']); ?>">
            <div class="form-group">
              <label for="template_name">Template Name:</label>
              <input type="text" name="template_name" class="form-control" required value="<?php echo htmlspecialchars($edit_template['template_name']); ?>">
            </div>
            <div class="form-group">
              <label for="template_file">Upload New Template File (HTML only, optional):</label>
              <input type="file" name="template_file" class="form-control-file">
            </div>
            <div class="form-group">
              <label for="preview_image">Upload New Preview Image (optional):</label>
              <input type="file" name="preview_image" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Update Template</button>
            <a href="manage_templates.php" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    <?php else: ?>
      <div class="card mb-4">
        <div class="card-header">Upload New Template</div>
        <div class="card-body">
          <form method="POST" action="manage_templates.php" enctype="multipart/form-data">
            <div class="form-group">
              <label for="template_name">Template Name:</label>
              <input type="text" name="template_name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="template_file">Select Template File (HTML only):</label>
              <input type="file" name="template_file" class="form-control-file" required>
            </div>
            <div class="form-group">
              <label for="preview_image">Select Preview Image (JPG, JPEG, PNG, or GIF):</label>
              <input type="file" name="preview_image" class="form-control-file">
            </div>
            <input type="hidden" name="upload_template" value="1">
            <button type="submit" class="btn btn-success">Upload Template</button>
          </form>
        </div>
      </div>
    <?php endif; ?>
    
    <!-- List of Uploaded Templates -->
    <h3>Existing Templates</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Template Name</th>
          <th>File Path</th>
          <th>Preview Image</th>
          <th>Uploaded At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result_templates && $result_templates->num_rows > 0): ?>
          <?php while ($temp = $result_templates->fetch_assoc()): ?>
            <tr>
              <td><?php echo $temp['id']; ?></td>
              <td><?php echo htmlspecialchars($temp['template_name']); ?></td>
              <td><?php echo htmlspecialchars($temp['file_path']); ?></td>
              <td>
                <?php if (!empty($temp['preview_image'])): ?>
                  <img src="<?php echo htmlspecialchars($temp['preview_image']); ?>" alt="<?php echo htmlspecialchars($temp['template_name']); ?>" style="width:100px;">
                <?php else: ?>
                  N/A
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($temp['created_at'] ?? ''); ?></td>
              <td>
                <a href="manage_templates.php?template_edit=<?php echo $temp['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="manage_templates.php?template_delete=<?php echo $temp['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this template?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6">No templates uploaded.</td>
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
